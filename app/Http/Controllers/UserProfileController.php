<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tag; 

class UserProfileController extends Controller
{
    public function changePassword($id)
{
    if (auth()->id() != $id) {
        abort(403, 'Access denied');
    }

    $user = User::findOrFail($id);

    return view('pages.changePassword', compact('user'));
}

    public function showUserProfile($id)
{
    $user = User::with(['followedTags', 'questions', 'answers', 'badges'])->findOrFail($id);
    $tags = Tag::all(); 

    $title = auth()->id() == $id ? "My Profile" : "{$user->first_name} {$user->last_name}'s Profile";

    return view('pages.userProfile', [
        'title' => $title,
        'user' => $user,
        'tags' => $tags,
    ]);
}
    public function edit($id)
    {
        if (auth()->id() != $id) {
            abort(403, 'Access denied');
        }

        $user = User::findOrFail($id);
        $title = "Edit Profile";

        return view('pages.editProfile')->with([
            'title' => $title,
            'user' => $user,
        ]);
    }
 
    public function update(Request $request, $id)
    {
    if (auth()->id() != $id) {
        abort(403, 'Access denied');
    }

    $messages = [
        'name.required' => 'The username is required.',
        'name.max' => 'The username must not exceed 50 characters.',
        'email.required' => 'The email address is required.',
        'email.email' => 'Please provide a valid email address.',
        'email.unique' => 'The email address is already in use.',
        'description.max' => 'The description must not exceed 150 characters.',
    ];

    $request->validate([
        'first_name' => 'nullable|string|max:50',
        'last_name' => 'nullable|string|max:50',
        'name' => [
                'required',
                'string',
                'max:250',
                'regex:/^[\w\sáàãâäéèêëíìîïóòôöúùûüç\.\-_]+$/i',
                'unique:user,name,' . $id . ',user_id', 
            ] ,
        'email' => 'required|email|max:250|unique:user,email,' . $id . ',user_id',
        'description' => 'nullable|string|max:150',
    ], $messages);

    $user = User::findOrFail($id);

    $user->update([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'name' => $request->name,
        'email' => $request->email,
        'description' => $request->description,
    ]);

    return redirect()->route('userProfile', ['id' => $id])
        ->with('success', 'Profile updated successfully!');
}



public function updatePassword(Request $request, $id)
{
    if (auth()->id() != $id) {
        abort(403, 'Access denied');
    }

    $request->validate([
        'current_password' => ['required', 'current_password'], 
        'new_password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $user = User::findOrFail($id);
    $user->password = bcrypt($request->new_password);
    $user->save();

    return redirect()->route('userProfile', ['id' => $id])
        ->with('success', 'Senha alterada com sucesso!');
}

public function showUserAnswers()
    {
        $user = auth()->user(); 
        $answers = $user->answers;

        return view('profile', compact('user', 'answers'));
    }

    
    public function addTags(Request $request, $id)
{
    if (auth()->id() != $id) {
        abort(403, 'Access denied');
    }

    $user = User::findOrFail($id);

    $tags = $request->input('tags', []); 
    $user->followedTags()->sync($tags); 

    return redirect()->route('userProfile', ['id' => $id])
        ->with('success', 'Tags updated successfully!');
}


}


