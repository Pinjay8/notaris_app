<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserSyncController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'notaris_id' => 'required|exists:notaris,id',
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:6',
                'email' => 'required|email|unique:users,email',
                'signup_at' => 'required|date',
                'active_at' => 'required|date',
                'status' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ]);

            $user = User::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat',
                'user' => $user
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
