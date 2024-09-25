<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // auth dari BI
    public const header = [
        'X-SIGNATURE' => '123456',
        'X-PARTNER-ID' => '123456'
    ];

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

    // login user
    public function login(Request $request)
    {
        $input = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $input['email'])->first();
        // cek password
        if (!$user || !Hash::check($input['password'], $user->password)) {
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = $user->createToken('TokenRahasiInix')->plainTextToken;
        $data = [
            'status' => Response::HTTP_OK,
            'message' => 'User berhasil login',
            'data' => $user,
            'token' => $token,
            'type' => 'Bearer'
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    // detail user
    public function user()
    {
        $data = [
            'status' => Response::HTTP_OK,
            'user' => auth()->user(),
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    public function logout()
    {
        // revoke login token
        auth()->user()->tokens->each(function ($token) {
            $token->delete();
        });

        $data = [
            'status' => Response::HTTP_OK,
            'message' => 'Logout berhasil',
        ];
        return response()->json($data, Response::HTTP_OK);
    }
}
