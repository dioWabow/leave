<?php

namespace App\Notifications;

use App\Config;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class AgentNoticeSlack extends Notification
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
    public function __construct($name,$start_time,$to)
    {
        $this->title .= "假單申請通知：";

        $text = "";
        $text .= $name.' 於 '.$start_time." 將請假並指定您為代理人\n";
        $text .= "請盡速進行確認是否同意，謝謝。"
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
    * Get the Slack representation of the notification. 
    * 
    * @param  mixed  $notifiable 
    * @return SlackMessage 
    */
    public function toSlack($notifiable)
    {
        $url = route("agent/index");
        $title = $this->title;
        $text = $this->text;
        return (new SlackMessage) 
            ->from(Config::getConfigValueByKey("slack_botname"), ':wabow:') 
            ->to('@'.$this->to) 
            ->success()
            ->attachment(function ($attachment) use ($url,$title,$text) {
                $attachment
                    ->title($title, $url)
                    ->content($text)
                    ->markdown(['title', 'text']);
            });
    }
}
