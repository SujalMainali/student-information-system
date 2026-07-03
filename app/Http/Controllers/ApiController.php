<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Requests\LoginRequest;
use App\Models\User;

class ApiController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) { 
            // Authentication failed
            return response()->json([
                'message' => 'Invalid credentials'
                ], 401);
        }

        $token = $user->createToken(
            $request->input('device_name', 'api_client'),
            ['*']
        );

        return response()->json([
            'message' => 'Login successful.',
            'token_type' => 'Bearer',
            'access_token' => $token->plainTextToken,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role ?? null,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

       $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ], 200);
    }
}
