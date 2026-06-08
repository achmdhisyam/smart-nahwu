<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class LupaPasswordController extends Controller
{
    /**
     * Tampilkan form pengajuan lupa password.
     */
    public function showLinkRequestForm()
    {
        return view('auth.lupa-password');
    }

    /**
     * Kirim email dengan tautan reset password.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            [
                'email.required' => 'Alamat email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.exists' => 'Alamat email ini tidak terdaftar di sistem.',
            ]
        );

        // Kirim link reset password via Broker bawaan Laravel (akan terekam di log file)
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Kami telah mengirimkan tautan reset password ke email Anda. Silakan periksa kotak masuk atau folder spam Anda.')
            : back()->withErrors(['email' => 'Gagal mengirimkan email reset password.']);
    }

    /**
     * Tampilkan form untuk mereset password baru.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Lakukan reset password pengguna di database.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak cocok dengan data kami.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password harus minimal 8 karakter.',
        ]);

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
