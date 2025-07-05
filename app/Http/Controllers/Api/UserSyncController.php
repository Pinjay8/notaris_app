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
        $validated = $request->validate([
            'notaris_id' => 'required',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6', // Pastikan sudah di-hash jika tidak hash di sini
            'email' => 'required|email|unique:users,email',
            'signup_at' => 'required',
            'active_at' => 'required',
            'status' => 'required',
        ]);

        $user = User::create($validated);

        return response()->json([
            'message' => 'User berhasil dibuat',
            'user' => $user
        ], 201);
    }
}
