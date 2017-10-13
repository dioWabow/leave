<?php

namespace App\Notifications;

use App\Config;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserLeaveReturnEmail extends Notification
{
    use Queueable;

    public $time = "";//請假時間

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($time)
    {
        $this->time = $time;
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
            ->from(Config::getConfigValueByKey("smtp_from") , Config::getConfigValueByKey("smtp_display"))
            ->subject("假單取消通知 - ". Config::getConfigValueByKey("smtp_display"))
            ->line("您於 ". $this->time ."期間的假單已被取消");
    }

}
