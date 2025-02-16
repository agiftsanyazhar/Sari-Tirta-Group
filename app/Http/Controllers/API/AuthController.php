<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'preferred_timezone' => 'required|string|max:255|exists:users,preferred_timezone',
                'password' => 'required|string|min:8',
            ]);

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            $token = $user->createToken('auth_token', ['*'], now()->addHour())->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User successfully added.',
                'token' => $token,
                'data' => $user,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error occurred.',
                'errors' => ['error' => $e->getMessage()],
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'username' => 'required|string|max:255',
                'password' => 'required|string|min:8',
            ]);

            $user = User::where('username', $data['username'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'message' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user->tokens()->delete();

            $token = $user->createToken('auth_token', ['*'], now()->addHour())->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successfully.',
                'token' => $token,
                'data' => $user,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error occurred.',
                'errors' => ['error' => $e->getMessage()],
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = User::findOrFail($request->user()->id);
            $user->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout successfully.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error occurred.',
                'errors' => ['error' => $e->getMessage()],
            ], 500);
        }
    }
}
