<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate(rules: [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create(attributes:[
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(value:$request->password)
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'authorization' => [
                'token' => $token,
                'type' => 'Bearer',
            ]
        ]);
    }

    public function login(Request $request): JsonResponse{
        $request->validate(rules: [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if(!$token){
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ],401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'authorization' => [
                'token' => $token,
                'type' => 'Bearer',
            ]
        ]);
    }

    public function logout(Request $request): JsonResponse{
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully'
        ]);
    }

}
