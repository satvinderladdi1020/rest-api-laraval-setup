<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class AuthForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    
    public function sendResetLinkEmail(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => $validator->errors()
        ], 422);
    }

    $response = $this->broker()->sendResetLink(
        $request->only('email')
    );

    if ($response == Password::RESET_LINK_SENT) {
        return response()->json([
        'message' => 'Reset link sent to your email'
    ]);
} else {
    return response()->json([
        'error' => 'Unable to send reset link'
    ], 422);
}
}
}
