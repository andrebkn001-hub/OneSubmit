<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     */
    public function __construct(public string $token)
    {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        // Generate URL consistent with existing password reset route pattern
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Get expiry (default fallback 60 if not configured)
        $expire = (int) config('auth.passwords.' . config('auth.defaults.passwords') . '.expire', 60);

        return (new MailMessage)
            ->subject('Reset Kata Sandi ' . config('app.name'))
            ->greeting('Halo!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda di ' . config('app.name') . '.')
            ->line('Silakan klik tombol di bawah ini untuk mengatur ulang kata sandi Anda:')
            ->action('Reset Kata Sandi', $url)
            ->line('Tautan untuk reset kata sandi ini akan kedaluwarsa dalam ' . $expire . ' menit.')
            ->line('Jika Anda tidak merasa meminta reset kata sandi, Anda dapat mengabaikan email ini dan tidak ada tindakan lebih lanjut yang diperlukan.')
            ->salutation('Salam hangat,' . "\n" . config('app.name'));
    }
}
