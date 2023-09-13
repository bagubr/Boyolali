<?php

namespace App\Notifications;

use App\Models\UserInformation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TolakAgenda extends Notification
{
    use Queueable;

    protected $user_information;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UserInformation $user_information)
    {
        $this->user_information = $user_information;
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
        return (new MailMessage)->subject('Nomor Agenda')
                    ->greeting('Hai '. $this->user_information->user->name)
                    ->line('Maaf permohonan anda di tolak dengan alasan : '. $this->user_information->riwayat_new[0]->note)
                    ->line($this->user_information->note)
                    ->action('Cek Agenda', route('detail', ['id' => $this->user_information->id]));
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
