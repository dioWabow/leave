<?php

namespace App\Notifications;

use App\Config;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OtherLeaveSuccessEmail extends Notification
{
    use Queueable;

    public $time = "";//請假時間
    public $name = "";//請假時間

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name , $time)
    {
        $this->time = $time;
        $this->name = $name;
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
            ->subject("假單通過額外通知 - ". Config::getConfigValueByKey("smtp_display"))
            ->line($this->name .'於 '. $this->time ."期間")
            ->line('的請假已通過審核');
    }

}
