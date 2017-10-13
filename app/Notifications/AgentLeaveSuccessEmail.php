<?php

namespace App\Notifications;

use App\Config;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AgentLeaveSuccessEmail extends Notification
{
    use Queueable;

    public $name = "";//請假人
    public $time = "";//請假時間

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name,$time)
    {
        $this->name = $name;
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
            ->subject("假單職代通知 - ". Config::getConfigValueByKey("smtp_display"))
            ->line('您於 '. $this->time ."期間為 ".$this->name." 職務代理人")
            ->line('注意,任職職務代理人期間無法請假(病假除外)');
    }

}
