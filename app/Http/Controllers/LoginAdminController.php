<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginAdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah terdaftar
            $user = User::where('email', $googleUser->email)->first();

            // Jika user belum terdaftar, buat akun baru
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make('password'), // Default password
                ]);
            }

            // Login user
            Auth::login($user);

            // Redirect ke dashboard_admin setelah login
            return redirect()->route('show_dashboard_admin');
        } catch (\Exception $e) {
            // Redirect ke halaman login_admin jika terjadi kesalahan
            return redirect('/login_admin')->withErrors('Login failed, please try again.');
        }
    }
}
