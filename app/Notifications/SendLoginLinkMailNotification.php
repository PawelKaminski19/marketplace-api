<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendLoginLinkMailNotification extends Notification
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
        $this->hash = $vars["hash"];
        $this->fullUsername = $vars["fullUsername"];
        $this->expiration_minutes = $vars["expiration_minutes"];
        $this->domain = $vars["domain"];
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
            ->view('emails.verify.login.link.email',
                [
                    "fullUsername" => $this->fullUsername,
                    "hash" => $this->hash,
                    "expiration_minutes" => $this->expiration_minutes,
                    "domain" => $this->domain
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
