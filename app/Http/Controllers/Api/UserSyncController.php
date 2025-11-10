<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


    // public function store(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'notaris_id' => 'required|exists:notaris,id',
    //             'username' => 'required|string|max:255|unique:users,username',
    //             'password' => 'required|string|min:6',
    //             'email' => 'required|email|unique:users,email',
    //             'signup_at' => 'nullable|date',
    //             'active_at' => 'nullable|date',
    //             'status' => 'required',
    //             'phone' => 'required',
    //             'address' => 'required',
    //         ]);

    //         $user = User::create($validated);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'User berhasil dibuat',
    //             'user' => $user
    //         ], 201);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validasi gagal',
    //             'errors' => $e->errors()
    //         ], 422);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Terjadi kesalahan pada server',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi bagian user
            $validatedUser = validator($request->input('user'), [
                'notaris_id' => 'required|exists:notaris,id',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:6',
                'phone' => 'required|string',
                'address' => 'required|string',
                'status' => 'required|string',
            ])->validate();

            // Validasi bagian subscription
            $validatedSubscription = validator($request->input('user.subscription'), [
                'plan_id' => 'required|exists:plans,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'status' => 'required|string',
            ])->validate();

            // Simpan user
            $user = User::create([
                'notaris_id' => $validatedUser['notaris_id'],
                'email' => $validatedUser['email'],
                'username' => $validatedUser['username'],
                'password' => bcrypt($validatedUser['password']),
                'phone' => $validatedUser['phone'],
                'address' => $validatedUser['address'],
                'status' => $validatedUser['status'],
            ]);

            // Simpan subscription
            $subscription = Subscriptions::create([
                'user_id' => $user->id,
                'plan_id' => $validatedSubscription['plan_id'],
                'start_date' => $validatedSubscription['start_date'],
                'end_date' => $validatedSubscription['end_date'],
                'status' => $validatedSubscription['status'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User dan subscription berhasil disync',
                'data' => [
                    'user' => $user,
                    'subscription' => $subscription
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi error.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
