<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactFormMessage extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(contactFormRequest $message)
    {
        $this->message = $message;
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
            // ->subject(config('recipient.name') . ", you have a new message!")
            ->subject('[Contact Form] ' . $this->message->subject)
            ->greeting(" ")
            ->salutation(" ")
            ->from($this->message->email, $this->message->name)
            ->line("You have a new message from " . $this->message->name . ".")
            ->line("Phone: " . $this->message->phone)
            ->line("Subject: " . $this->message->subject)
            ->line($this->message->message);
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
