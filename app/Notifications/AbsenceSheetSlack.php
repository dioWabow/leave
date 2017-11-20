<?php

namespace App\Notifications;

use App\Config;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class AbsenceSheetSlack extends Notification
{
    use Queueable;

    public $title = "";//標題
    public $text = "";//內文
    public $to = "";//傳送至

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($to)
    {
        $this->title .= "工作日誌未填通知：";

        $text = "";
        $text .= "您的工作日誌尚未填寫，請盡速填寫，謝謝";
        $this->text .= $text;

        $this->to .= $to;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage 
     */
    public function toSlack($notifiable)
    {
        $url = route('sheet/daily/index');
        $title = $this->title;
        $text = $this->text;
        return (new SlackMessage)
        ->from(Config::getConfigValueByKey('slack_botname'), ':wabow:') 
        ->to('@'.$this->to) 
        ->attachment(function ($attachment) use ($url, $title, $text) {
            $attachment
                ->title($title, $url)
                ->content($text)
                ->markdown(['title', 'text']);
        });
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
