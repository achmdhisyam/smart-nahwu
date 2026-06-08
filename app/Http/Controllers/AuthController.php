<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Administrator!');
            }

            return redirect()->route('dashboard')->with('success', 'Selamat datang kembali!');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Tampilkan form registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi pengguna baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'santri', // Default role
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat belajar!');
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('analisis.index')->with('success', 'Anda telah keluar.');
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal menghubungkan ke Google: ' . $e->getMessage());
        }
    }

    /**
     * Handle Google Callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            return $this->loginOrCreateUser($googleUser);
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login menggunakan Google: ' . $e->getMessage());
        }
    }

    /**
     * Helper to authenticate or register user.
     */
    protected function loginOrCreateUser($socialUser, $defaultRole = 'santri')
    {
        // Cari user berdasarkan google_id atau email
        $user = User::where('google_id', $socialUser->getId())
            ->orWhere('email', $socialUser->getEmail())
            ->first();

        if ($user) {
            // Update google_id jika belum ada
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $socialUser->getId(),
                    'google_token' => $socialUser->token ?? null,
                    'google_refresh_token' => $socialUser->refreshToken ?? null,
                ]);
            }
            Auth::login($user);
        } else {
            // Buat user baru
            $user = User::create([
                'name' => $socialUser->getName() ?? explode('@', $socialUser->getEmail())[0],
                'email' => $socialUser->getEmail(),
                'google_id' => $socialUser->getId(),
                'google_token' => $socialUser->token ?? null,
                'google_refresh_token' => $socialUser->refreshToken ?? null,
                'role' => $defaultRole,
                'password' => null, // Google user tidak membutuhkan password
            ]);
            Auth::login($user);
        }

        return redirect()->intended('/dashboard')->with('success', 'Berhasil masuk menggunakan Google.');
    }
}
