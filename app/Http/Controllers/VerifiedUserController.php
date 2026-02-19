<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifiedUser;
class VerifiedUserController extends Controller
{
    public function checkVerificationStatus()
    {
        $userVerification = VerifiedUser::where('user_id', auth()->id())->first();

        if ($userVerification) {
            return response()->json([
                'status' => $userVerification->status ? 'verified' : 'pending',
                'message' => $userVerification->status ? 'You are verified.' : 'Your verification is pending.',
            ]);
        }

        return response()->json([
            'status' => 'not_applied',
            'message' => 'You have not applied for verification.',
        ]);
    }

    public function destroyVerifiedUser($id)
    {
        $verifiedUser = VerifiedUser::where('user_id', $id)->firstOrFail();

        $verifiedUser->delete();

        return redirect()->route('admin.verificationRequests')->with('success', 'Verification request deleted successfully!');

    }

}
