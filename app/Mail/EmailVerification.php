<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Job\Employers\Employer;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *  ユーザインスタンス
     *  @var Employer
     */
    public $employer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Employer $employer)
    {
        $this->employer = $employer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('【JOBCiNEMA】仮登録が完了しました')
            ->replyTo('official@job-cinema.com')
            ->view('emails.employer.pre_register')
            ->with(['token' => $this->employer->email_verify_token]);
        
    }
}
