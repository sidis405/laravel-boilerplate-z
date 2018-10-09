<?php

namespace Blog\Api\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $token = null;

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'response' => 'error',
                'message' => 'invalid_credentials'
            ], 403);
        }

        return response()->json([
            'response' => 'success',
            'result' => [
                'token' => $token,
                'user' => auth()->user()
            ]
        ], 200);
    }
}
