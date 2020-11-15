<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisteredMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     *  ユーザインスタンス
     *  @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('会員登録が完了しました')
            ->replyTo(config('mail.reply.address'))
            ->view('emails.seeker.registered');
    }
}
