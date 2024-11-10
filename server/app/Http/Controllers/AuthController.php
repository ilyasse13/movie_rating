<?php

namespace App\Http\Controllers;

use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
    ]);

    try {
        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verification_code' => random_int(100000, 999999), // Generate a 6-digit verification code
        ]);

        // Send the verification code via email
        Mail::to($user->email)->send(new VerificationEmail($user));

        return response()->json([
            'message' => 'Registration successful, please check your email for verification.'
        ], 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Registration failed.'], 500);
    }
}

public function login(Request $request)
{
    $data = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:8',
    ]);

    $user = User::where('email', $data['email'])->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
        return response()->json(['message' => 'Email or password is incorrect!'], 401);
    }

    $token = $user->createToken('accessToken')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
        'message' => 'Login successful'
    ]);
}

public function verifyEmail(Request $request)
{
    $data = $request->validate([
        'verification_code' => 'required|integer|digits:6',
    ]);

    $user = User::where('verification_code', $data['verification_code'])->first();

    if (!$user) {
        return response()->json(['message' => 'Invalid or expired verification code.'], 422);
    }

    $user->email_verified_at = now();
    $user->verification_code = null;
    $user->save();

    $token = $user->createToken('Personal Access Token')->plainTextToken;

    return response()->json([
        'message' => 'Email successfully verified.',
        'user' => $user,
        'token' => $token
    ]);
}

public function logout(Request $request)
{
    try {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out.']);
    } catch (\Exception $e) {
        Log::error('Logout error: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while attempting to log out.'], 500);
    }
}

public function userdata(Request $request)
{
    try {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        return response()->json(['user' => $user], 200);
    } catch (\Exception $e) {
        Log::error('User data retrieval error: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while retrieving user data.'], 500);
    }
}

}
