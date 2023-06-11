<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    protected function verificationUrl($notifiable)
    {
        $temporarySignedRoute = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        $signedUrlParts = parse_url($temporarySignedRoute);

        $path = str_replace('/api', '', $signedUrlParts['path']);

        $frontEndDomain = 'http://localhost:8081';

        $frontendUrl = $frontEndDomain . $path . '?' . $signedUrlParts['query'];

        $frontendUrl .= '&email_verified=true';

        return $frontendUrl;
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        // Log::info($verificationUrl);
        return (new MailMessage)
            ->subject('Verify your email address')
            ->markdown('emails.verify-email', ['url' => $verificationUrl, 'user' => auth()->user()]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
}
