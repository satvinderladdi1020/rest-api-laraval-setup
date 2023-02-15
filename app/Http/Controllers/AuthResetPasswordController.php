<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\User;
class AuthResetPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    
    public function reset(Request $request)
{
$validator = Validator::make($request->all(), [
'email' => 'required|email',
'token' => 'required',
'password' => 'required|min:6|confirmed',
]);
if ($validator->fails()) {
    return response()->json([
        'error' => $validator->errors()
    ], 422);
}

$response = $this->broker()->reset(
    $request->only('email', 'password', 'password_confirmation', 'token'),
    function ($user, $password) {
        $user->password = Hash::make($password);
        $user->save();
    }
);

if ($response == Password::PASSWORD_RESET) {
    return response()->json([
        'message' => 'Password reset successfully'
    ]);
} else {
    return response()->json([
        'error' => 'Unable to reset password'
    ], 422);
}
}
}
