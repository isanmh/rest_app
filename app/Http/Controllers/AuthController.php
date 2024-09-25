<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // login user
    public function register(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|string:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // create user
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            // 'password' => Hash::make($input['password']),

        ]);

        // create token
        $token = $user->createToken('TokenRahasiInix')->plainTextToken;
        $data = [
            'status' => Response::HTTP_OK,
            'message' => 'User berhasil dibuat',
            'data' => $user,
            'token' => $token,
            'type' => 'Bearer'
        ];
        return response()->json($data, Response::HTTP_OK);
    }
}
