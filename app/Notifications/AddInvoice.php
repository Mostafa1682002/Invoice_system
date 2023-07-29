<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInvoice extends Notification
{
    use Queueable;
    public $invoice_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = "http://localhost:8000/invoiceDetails/$this->invoice_id";
        return (new MailMessage)
            ->greeting('مرحبا بك')
            ->subject('اضافة فاتوره جديده')
            ->line('تم اضافة فاتوره جديده')
            ->action('عرض الفاتوره', $url)
            ->line('شكرا الاستخدامك مشروع تحصيل الفواتير');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'user_name' => auth()->user()->name,
            'invoice_id' => $this->invoice_id,
        ];
    }
}
