<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Token reset password.
     *
     * @var string
     */
    public $token;

    /**
     * Buat instance notification baru.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Tentukan channel pengiriman.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Dapatkan representasi mail dari notification.
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Atur Ulang Kata Sandi Akun Smart Nahwu')
            ->view('emails.reset-password', [
                'url' => $url,
                'name' => $notifiable->name
            ]);
    }
}
