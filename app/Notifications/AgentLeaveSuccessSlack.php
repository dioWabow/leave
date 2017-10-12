<?php

namespace App\Notifications;

use App\Config;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class AgentLeaveSuccessSlack extends Notification
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
    public function __construct($name,$start_time,$end_time,$to)
    {
        $this->title .= "假單職代通知：";

        $text = "";
        $text .= "您於 ".$start_time." 至 ".$end_time." 期間為 ".$name." 的職務代理人。\n";
        $text .= "注意, 任職職務代理人期間無法請假(病假除外)";
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
        $url = route("index");
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
