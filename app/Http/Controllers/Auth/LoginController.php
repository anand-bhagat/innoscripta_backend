<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            $user = auth()->user();

            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json(['message' => 'Logged in successfully', 'token' => $token]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
