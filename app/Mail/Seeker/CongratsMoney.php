<?php

namespace App\Mail\Seeker;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CongratsMoney extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $apply;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($apply)
    {
        $this->subject = '【JOB CiNEMA】お祝い金申請のお知らせ';
        $this->apply = $apply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.seeker.application.allow_congrats_money')
            ->replyTo(config('mail.reply.address'))
            ->subject($this->subject);
    }
}
