<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;
    public $addr;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->addr = $this->order->billingAddress()->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];

//        $channels = ['database'];
//        if ($notifiable->notification_preferences['order_created']['sms'] ?? false) {
//            $channels[] = 'sms';
//        }
//        if ($notifiable->notification_preferences['order_created']['mail'] ?? false) {
//            $channels[] = 'mail';
//        }
//        if ($notifiable->notification_preferences['order_created']['broadcast'] ?? false) {
//            $channels[] = 'broadcast';
//        }
//        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("New Order #{$this->order->number}")
            ->greeting("Hello {$notifiable->name}")
            ->line("A New Order (#{$this->order->number}) Created By {$this->addr->name} From {$this->addr->country_name}.")
            ->action('View Order', url('/dashboard'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'body' => "A New Order (#{$this->order->number}) Created By {$this->addr->name} From {$this->addr->country_name}.",
            'icon' => "fas fa-file",
            'url' => url('/dashboard'),
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage(
            [
                'body' => "A New Order (#{$this->order->number}) Created By {$this->addr->name} From {$this->addr->country_name}.",
                'icon' => "fas fa-file",
                'url' => url('/dashboard'),
                'order_id' => $this->order->id,
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
