<?php

namespace App\Notifications;

use App\Models\UserInformation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenerateFile extends Notification
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
        return (new MailMessage)->subject('Nomor Surat Keterangan KRK')
                    ->greeting('Hai '. $this->user_information->user->name)
                    ->line('Selamat KRK anda berhasil di buat silahkan download file anda di bawah ini :')
                    ->line('Nomor KRK : '. $this->user_information->nomor_krk)
                    ->action('Download Berkas', asset('storage/krks/'.$this->user_information->uuid.'.pdf'))
                    ->line('Terima kasih sudah menggunakan aplikasi kami');
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
