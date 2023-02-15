<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthLoginController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    $validator = Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => $validator->errors()
        ], 422);
    }

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('API Token')->accessToken;
        $token = $user->generateApiToken();
        return response()->json([
            'token' => $token
        ]);
    } else {
        return response()->json([
            'error' => 'Invalid credentials'
        ], 401);
    }
}
}
