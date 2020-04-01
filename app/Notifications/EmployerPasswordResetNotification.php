<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class EmployerPasswordResetNotification extends ResetPasswordNotification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('【JOBCiNEMA】パスワード再設定')
            ->line('下のボタンをクリックしてパスワードを再設定してください。')
            ->action('パスワード再設定', url(config('url').route('employer.password.reset', $this->token, false)))
            ->line('もし心当たりがない場合は、本メッセージは破棄してください。');
    }
}