<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Email Anda')
                ->line('Klik untuk verifikasi email anda.')
                ->action('Verifikasi', $url);
        });
        ResetPassword::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Reset Password')
                ->line('Anda menerima email ini karena kami menerima permintaan reser password dari akun anda ')
                ->action('Reset Password', $url)
                ->line(Lang::get('Link Password Reset ini akan kadaluarsa dalam 60 menit.'))
                ->line(Lang::get('Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini.'));
        });
    }
}
