<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UpdateEmailNotification extends Notification
{
    use Queueable;
    /**
     * Create a new notification instance.
     */
    public function __construct(public $newEmail)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */

    protected function verificationUrl($notifiable)
    {
        $token = Str::random(60);

        Cache::put($token, ['user_id' => $notifiable->id, 'new_email' => $this->newEmail], 60);

        $temporarySignedRoute = URL::temporarySignedRoute(
            'email-change.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($this->newEmail),
                'token' => $token,
            ]
        );

        $signedUrlParts = parse_url($temporarySignedRoute);

        $path = str_replace('/api', '', $signedUrlParts['path']);

        $frontEndUrl = env('FRONTEND_URL', 'http://localhost:8081');

        $frontendUrl = $frontEndUrl . $path . '?' . $signedUrlParts['query'];

        $frontendUrl .= '&email_verified=true';

        return $frontendUrl;
    }

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        return (new MailMessage)
            ->subject('Verify your new email address')
            ->markdown('emails.verify-email', ['url' => $verificationUrl, 'user' => auth()->user()]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
