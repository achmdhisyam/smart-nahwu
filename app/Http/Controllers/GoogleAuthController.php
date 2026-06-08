<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
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
