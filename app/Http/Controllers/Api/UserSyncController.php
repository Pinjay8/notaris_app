<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserSyncController extends Controller
{
    public function index()
    {
        try {
            $users = User::orderBy('created_at', 'desc')->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No users found',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'User data successfully retrieved',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user data',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'notaris_id' => 'required|exists:notaris,id',
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:6',
                'email' => 'required|email|unique:users,email',
                'signup_at' => 'nullable|date',
                'active_at' => 'nullable|date',
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
