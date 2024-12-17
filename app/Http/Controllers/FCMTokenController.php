<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 


class FCMTokenController extends Controller
{
    public function saveFirebaseToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        try {
            $user->update(['token_firebase' => $request->token]);
            return response()->json(['message' => 'Token saved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to save token', 'error' => $e->getMessage()], 500);
        }
    }
}
