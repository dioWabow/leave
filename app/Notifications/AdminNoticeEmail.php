<?php

namespace App\Notifications;

use App\Config;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminNoticeEmail extends Notification
{
    use Queueable;

    public $name = "";//請假人
    public $start_time = "";//請假時間

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name,$start_time)
    {
        $this->name = $name;
        $this->start_time = $start_time;
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
            ->subject("假單申請通知". Config::getConfigValueByKey("smtp_display"))
            ->line($this->name.' 於 '.$this->start_time." 將請假")
            ->line('請盡速進行確認是否同意，謝謝。')
            ->action('點我進入', route("leaves_manager/prove",["role"=>"admin"]));
    }

}
