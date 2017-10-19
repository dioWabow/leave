<?php

namespace App\Notifications;

use App\Config;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class CronDailyLeave extends Notification
{
    use Queueable;

     protected $title = "";
     protected $text = "";
     protected $channel = "";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($leave_list)
    {
        //直接根據傳入三個變數的名字產生string
        $this->title .= date("Y/m/d")."請假狀況：";
        $text = "";
        if (!empty($leave_list["morning"])) {

            $text .= "上午:";
            foreach ($leave_list["morning"] as $key => $value) {

                $text .= $value;
                if ( $value != last($leave_list["morning"]) ) {

                    $text .= ",";

                }
            }

            $text .= "\n";

        }

        if (!empty($leave_list["afternoon"])) {
                
            $text .= "下午:";
            foreach ($leave_list["afternoon"] as $key => $value) {

                $text .= $value;
                if ( $value != last($leave_list["afternoon"]) ) {

                    $text .= ",";

                }
            }

        }

        if (!empty($leave_list["all_day"])) {
                
            $text .= "\n";
            $text .= "全天:";
            foreach ($leave_list["all_day"] as $key => $value) {

                $text .= $value;
                if ( $value != last($leave_list["all_day"]) ) {

                    $text .= ",";

                }
            }

        }

        $text .= "\n請同仁互相支援";
        $this->text .= $text;
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
        $url = Config::getConfigValueByKey("company_website");
        $title = $this->title;
        $text = $this->text;
        return (new SlackMessage) 
            ->from(Config::getConfigValueByKey("slack_botname"), ':wabow:') 
            ->to('#'.Config::getConfigValueByKey("slack_public_channel")) 
            ->success()
            ->attachment(function ($attachment) use ($url,$title,$text) {
                $attachment
                    ->title($title, $url)
                    ->content($text)
                    ->markdown(['title', 'text']);
            });
    }
}
