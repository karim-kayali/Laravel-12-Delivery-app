<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DeliveryPushNotification extends Notification
{
    use Queueable;

    public string $type;
    public mixed $data;

    public function __construct(string $type, $data = [])
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['broadcast']; // Or ['database', 'broadcast'] if we want to store it
    }

    public function toArray($notifiable)
    {
        switch ($this->type) {
            case 'reminder_for_driver':
                return [
                    'message' => 'Reminder: You have a scheduled delivery today.'
                ];

            case 'notify_client_delivery_day':
                return [
                    'message' => 'A driver will reach out to you for your deliveries today.'
                ];

            case 'notify_driver_new_request':
                return [
                    'message' => 'You have a new delivery request available. Accept or decline it now.'
                ];

            case 'notify_client_driver_accepted':
                return [
                    'message' => 'Good news! A driver has accepted your delivery request.'
                ];

            default:
                return [
                    'message' => 'Notification'
                ];
        }
    }
}


