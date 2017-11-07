<?php

namespace App\Notifications;

use App\Config;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;

class CronDailyWaitProve extends Notification
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
    public function __construct($wait_prove_list,$to)
    {
        $this->title .= date("Y/m/d")."假單未審核通知：";

        $text = "";
        if ( !empty( $wait_prove_list["agent"] ) ) {

            $text .= "您有尚未審核的職代假單\n";

        }

        if ( !empty( $wait_prove_list["minimanager"] ) ) {

            $text .= "您有尚未審核的小主管假單\n";

        }

        if ( !empty( $wait_prove_list["manager"] ) ) {

            $text .= "您有尚未審核的主管假單\n";

        }

        if ( !empty( $wait_prove_list["admin"] ) ) {

            $text .= "您有尚未審核的大BOSS假單\n";

        }

        $text .= "\n請盡速審核";

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
