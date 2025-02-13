<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GuestMailVerifyNotification extends Notification
{
    use Queueable;

    public $fullUsername;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($vars)
    {
        $this->token = $vars["token"];
        $this->fullUsername = $vars["fullUsername"];
        $this->expiration_minutes = $vars["expiration_minutes"];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.verify.guest.email',
                [
                    "fullUsername" => $this->fullUsername,
                    "token" => $this->token,
                    "expiration_minutes" => $this->expiration_minutes
                ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
