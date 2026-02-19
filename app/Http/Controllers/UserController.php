<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminUser;
use App\Models\ModeratorUser;
use App\Models\VerifiedUser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BlockedUser;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return view('pages.showUser', compact('user'));
    }

    public function index()
    {
        $title = "Users";

        $users = User::all();


        foreach ($users as $user) {
            if ($user->isAdmin() === true) {
                $user->role = 'Admin';

            } elseif ($user->isModerator()) {
                if ($user->isBlocked()) {
                    $user->role = 'Blocked Moderator';
                } else {
                    $user->role = 'Moderator';
                }

            } elseif ($user->isBlocked()) {
                $user->role = 'Blocked User';

            } else {
                $user->role = 'User';
            }

            if ($user->isDeleted()) {
                $user->role = 'Deleted';
            }
        }


        $admins = $users->where('role', 'Admin');
        $moderators = $users->where('role', 'Moderator');
        $blockedModerators = $users->where('role', 'Blocked Moderator');
        $blockedUsers = $users->where('role', 'Blocked User');
        $normalUsers = $users->where('role', 'User');
        $deletedUsers = $users->where('role', 'Deleted');

        $sortedUsers = $admins->merge($moderators)
            ->merge($blockedModerators)
            ->merge($normalUsers)
            ->merge($blockedUsers)
            ->merge($deletedUsers);

        return view('pages.admin.userAdministration', compact('sortedUsers', 'title'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->name = 'DELETED[' . substr(hash("md5", $id), 0, 10) . ']';
        $user->email = 'DELETED[' . substr(hash("md5", $id), 0, 10) . ']@example.com';

        $user->first_name = "[DELETED";
        $user->last_name = "USER]";
        $user->description = "[THIS USER HAS BEEN DELETED]";
        $user->password = hash("md5", $user->password);

        $user->save();

        return redirect()->route('user_administration')->with('success', 'User anonymized and logged out successfully!');
    }


    public function create(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:250',
                'regex:/^[\w\sáàãâäéèêëíìîïóòôöúùûüç\.\-_]+$/i',
                'unique:user,name',
            ],
            'email' => [
                'required',
                'email:rfc',
                'max:250',
                'unique:user,email',
            ],
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'The username is required.',
            'name.max' => 'The username must not exceed 250 characters.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please provide a valid email address (RFC 5322 format).',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = User::create([
            'first_name' => 'NEW',
            'last_name' => 'USER',
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => 'profile_pictures/default-profile.jpg',
        ]);


        if ($request->role === 'admin') {
            AdminUser::create(['admin_id' => $user->user_id]);
        } elseif ($request->role === 'moderator') {
            ModeratorUser::create(['moderator_id' => $user->user_id]);
        }

        return redirect()->route('user_administration')
            ->withSuccess('New user created successfully!');
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'The username is required.',
            'name.max' => 'The username must not exceed 20 characters.',
            'name.min' => 'The username must be at least 3 characters.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'first_name.max' => 'The first name must not exceed 20 characters.',
            'last_name.max' => 'The last name must not exceed 20 characters.',
            'description.max' => 'The description must not exceed 150 characters.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password_confirmation.required' => 'Password confirmation is required.',
        ];

        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'regex:/^[\w\sáàãâäéèêëíìîïóòôöúùûüç\.\-_]+$/i',
                'unique:user,name,' . $id . ',user_id',
            ],
            'email' => 'required|email|max:250|unique:user,email,' . $id . ',user_id',
            'first_name' => 'nullable|string|max:20',
            'last_name' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:150',
            'password' => 'nullable|string|min:6|confirmed',
        ], $messages);


        $user = User::findOrFail($id);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'description' => $request->description,
        ];

 
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('user_administration')->with('success', 'User updated successfully!');
    }


    public function applyForVerification(Request $request)
    {
        $request->validate([
            'degree' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'id_picture' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user = auth()->user();

        if (VerifiedUser::where('user_id', $user->user_id)->exists()) {
            return redirect()->back()->withErrors([
                'general' => 'You have already applied for verification.',
            ]);
        }

        $path = $request->file('id_picture')->store('id_pictures', 'public');

        VerifiedUser::create([
            'user_id' => $user->user_id,
            'degree' => $request->degree,
            'school' => $request->school,
            'id_picture' => $path,
            'status' => false,
        ]);

        return redirect()->route('userProfile', ['id' => $user->user_id])
            ->with('success', 'Verification application submitted successfully!');
    }

    public function showVerificationRequests()
    {
        $title = "Verification Requests";

        $verificationRequests = VerifiedUser::where('status', false)->get();

        return view('pages.verification_requests.verification_requests', compact('title', 'verificationRequests'));
    }

    public function verificationRequests()
    {
        $title = "Verification Requests";

        $verifications = VerifiedUser::with('user')->where('status', false)->get();

        return view('pages.verification_requests.verification_requests', compact('verifications', 'title'));
    }

    public function approveVerification($userId)
    {
        $verification = VerifiedUser::where('user_id', $userId)->first();

        if ($verification) {
            \Log::info("User ID {$userId} - Current status: {$verification->status}");

            $verification->status = true;
            $verification->save();

            \Log::info("User ID {$userId} - Updated status: {$verification->status}");

            return redirect()->route('admin.verificationRequests')->with('success', 'Verification approved.');
        }

        return redirect()->route('admin.verificationRequests')->withErrors(['general' => 'Verification record not found.']);
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_picture')) {
            if (
                !empty($user->profile_picture)
                && Storage::disk('public')->exists($user->profile_picture)
                && $user->profile_picture !== 'profile_pictures/7q8OoIMKQPTfsmgx0ypnYXtPkgWtbiEy6AhbPoOZ.jpg'
            ) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');

            $user->profile_picture = $path;
            $user->save();

            return redirect()->route('userProfile', ['id' => auth()->user()->user_id])->with('success', 'Profile picture updated!');
        }

        return redirect()->route('userProfile')->with('error', 'No file uploaded.');
    }

    public function block($id)
    {
        $user = User::findOrFail($id);

        BlockedUser::create(['blockeduser_id' => $user->user_id,]);

        $user->save();

        return redirect()->back()->with('success', 'User has been blocked successfully.');
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);

        BlockedUser::where('blockeduser_id', $user->user_id)->delete();

        $user->save();

        return redirect()->back()->with('success', 'User has been unblocked successfully.');
    }


    public function changeRole(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $newRole = $request->input('role'); 
        $newVerificationStatus = $request->input("verification");

        if ($user->isAdmin()) {
            $currentRole = 'Admin';
        } elseif ($user->isModerator()) {
            $currentRole = 'Moderator';
        } else {
            $currentRole = 'User';
        }

        if ($currentRole === 'Admin' && $newRole !== 'admin') {

            AdminUser::where('admin_id', $user->user_id)->delete();

            if ($newRole === 'moderator') {
                ModeratorUser::create(['moderator_id' => $user->user_id]);
            }
        }

        if ($currentRole === 'Moderator' && $newRole !== 'moderator') {

            ModeratorUser::where('moderator_id', $user->user_id)->delete();

            if ($newRole === 'admin') {
                AdminUser::create(['admin_id' => $user->user_id]);
            }
        }


        if ($currentRole === 'User' && $newRole !== 'user') {

            if ($newRole === 'admin') {
                AdminUser::create(['admin_id' => $user->user_id]);
            } elseif ($newRole === 'moderator') {
                ModeratorUser::create(['moderator_id' => $user->user_id]);
            }

        }


        if ($user->isVerified()) {
            $currentVerificationStatus = 'verified';
        } else {
            $currentVerificationStatus = 'unverified';
        }


        if ($newVerificationStatus !== $currentVerificationStatus) {

            if ($newVerificationStatus === 'unverified') {
                VerifiedUser::where('user_id', $user->user_id)->delete();
            }

            if ($newVerificationStatus === 'verified') {
                VerifiedUser::create([
                    'user_id' => $user->user_id,
                    'degree' => 'N/A', 
                    'school' => 'N/A', 
                    'id_picture' => 'N/A', 
                    'status' => true, 
                ]);

            }

        }


        $user->save();


        return redirect()->back()->with('success', 'User role and/or verification status updated successfully.');

    }



    public function add_adminRole($id)
    {
        $user = User::findOrFail($id);

        BlockedUser::where('blockeduser_id', $user->user_id)->delete();

        $user->save();

        return redirect()->back()->with('success', 'User has been unblocked successfully.');
    }



    public function add_moderatorRole($id)
    {
        $user = User::findOrFail($id);

        BlockedUser::where('blockeduser_id', $user->user_id)->delete();

        $user->save();

        return redirect()->back()->with('success', 'User has been unblocked successfully.');
    }
}
