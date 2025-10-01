<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credential = $request->validated();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            $userId = Auth::id(); // Simpan dulu user_id secara eksplisit

            // ActivityLog::create([
            //     'user_id'    => $userId,
            //     'menu'       => 'auth',
            //     'action'     => 'login',
            //     'data_type'  => 'users',
            //     'data_id'    => $userId,
            //     'ip_address' => $request->ip(),
            //     'description' => 'Melakukan Login',
            // ]);

            notyf()->position('x', 'right')->position('y', 'top')->success('Selamat datang, ' . Auth::user()->username . '!');
            return redirect()->route('dashboard');
        } else {
            notyf()->position('x', 'right')->position('y', 'top')->error('Email atau kata sandi salah.');
            return redirect()->route('login');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil Logout');
        return redirect()->route('login');
    }

    public function alertForgotPassword()
    {
        notyf()->position('x', 'right')->position('y', 'top')->info('Harus menghubungi admin untuk mengatur ulang kata sandi Anda.');
        return redirect()->route('login');
    }
}
