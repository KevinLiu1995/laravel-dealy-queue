<?php

namespace App\Notifications;

use App\ChouJiangRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChouZhongNotify extends Notification implements ShouldQueue
{
    use Queueable;

    protected $chouJiangRecord;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ChouJiangRecord $chouJiangRecord)
    {
        //
        $this->chouJiangRecord = $chouJiangRecord;
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
        $prize_list_name = json_decode($this->chouJiangRecord->name);
        $prize_list_value = json_decode($this->chouJiangRecord->value);

        return (new MailMessage)
                    ->subject('开奖通知')
                    ->greeting('Hello! 小老弟')
                    ->line('我的天呐‼️你居然中奖了‼️.')
                    ->line('看看你都中了啥：')
                    ->line($prize_list_name[0].'  价值：'.$prize_list_value[0])
                    ->line($prize_list_name[1].'  价值：'.$prize_list_value[1])
                    ->line($prize_list_name[2].'  价值：'.$prize_list_value[2])
//                    ->line('开奖时间：'.date('Y-m-d H:i:s'))√
//                    ->action('Notification Action', url('/'))
                    ->line('所有抽中的奖品都不会被寄出的，别做梦了！!🤣🤣🤣');
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
