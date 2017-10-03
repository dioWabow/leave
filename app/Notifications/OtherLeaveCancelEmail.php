<?php

namespace App\Notifications;

use App\Config;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OtherLeaveCancelEmail extends Notification
{
    use Queueable;

    public $start_time = "";//請假時間
    public $end_time = "";//請假時間
    public $name = "";//請假人

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name,$start_time,$end_time)
    {
        $this->start_time = $start_time;
        $this->end_time = $end_time;
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
            ->subject("假單取消額外通知 - ". Config::getConfigValueByKey("smtp_display"))
            ->line("您於 ".$this->start_time." 至 ".$this->end_time."期間的假單<font color='red'>已被取消</font>");
    }

}
