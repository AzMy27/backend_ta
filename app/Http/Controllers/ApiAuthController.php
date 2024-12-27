<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function loginAPI(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = $request->only(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email atau password salah'
                ], 401);
            }

            $user = Auth::user();
            if($user->level !=='dai'){
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
                'user'=>[
                    'id'=>$user->id,
                    'name'=>$user->name,
                    'email'=>$user->email ?? ""
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed'
            ]);
            $user = Auth::user();
            
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password lama salah'
                ], 400);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diganti',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password gagal diganti',
                'error' => $e->getMessage(),
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
