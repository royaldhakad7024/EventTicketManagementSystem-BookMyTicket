<?php

namespace App\Notifications;

use App\Models\Events;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class EventUpdateNotification extends Notification
{
    use Queueable;

    public $event_id;
    public $user_name;
    public $order_id;
    /**
     * Create a new notification instance.
     */
    public function __construct($event_id, $user_name, $order_id)
    {
        $this->event_id = $event_id;
        $this->user_name = $user_name;
        $this->order_id = $order_id;
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
    public function toMail(object $notifiable): MailMessage
    {
        /**
         * Get all info of event from event table. 
         */
        $event = Events::find($this->event_id);
        /**
         * Sent Email with subject and message.
         */
        return (new MailMessage)
            ->subject('The ' . $event->name . ' Event has been updated')
            ->line('Dear ' . $this->user_name . ',')
            ->line('The Ticket you have purchased for ' . $event->name . ' has been updated.Please Check the inforamation about ticket.')
            ->action('View Ticket', url('/EmailTicket/' . $this->order_id))
            ->line('Thank you for using our application!');
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