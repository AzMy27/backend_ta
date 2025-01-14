<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ApiAuthController extends Controller
{
    public function loginAPI(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengguna tidak terdaftar'
                ], 401);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password anda salah'
                ], 401);
            }

            Auth::login($user);
            if($user->level !== 'dai'){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda bukan pengguna dai',
                ],403);
            }

            $token = $user->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;
            return response()->json([
                'status' => 'success',
                'token' => $token,
                'token_type' => 'Bearer',
                'expired_at' => now()->addDays(7)->timestamp,
                'user'=>[
                    'id'=>$user->id,
                    'name'=>$user->name,
                    'email'=>$user->email ?? ""
                ]
            ]);

            if (!RateLimiter::attempt('login-attempts:'.$request->ip(), 5, 60)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Too many login attempts. Please try again later.'
                ], 429);
            }
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred'
            ], 500);
        }
    }

    public function logoutAPI(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during logout'
            ], 500);
        }
    }
}
