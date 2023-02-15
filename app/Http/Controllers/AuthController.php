<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        $user = User::create($request->all());
        $token = $user->createToken('MyApp')->accessToken;

        return response()->json(['token' => $token], 201);
    }
    

    public function forgotPassword(Request $request)
    {
        $response = Password::sendResetLink($request->only('email'));

        if ($response === Password::RESET_LINK_SENT) {
            return response()->json(['status' => trans($response)], 200);
        } else {
            return response()->json(['error' => trans($response)], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = $password;
            $user->save();
            event(new PasswordReset($user));
        });

        if ($response === Password::PASSWORD_RESET) {
            return response()->json(['status' => trans($response)], 200);
        } else {
            return response()->json(['error' => trans($response)], 400);
        }
    }


}
