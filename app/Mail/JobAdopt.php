<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobAdopt extends Mailable
{
    use Queueable, SerializesModels;

    public $employer = [];
    public $job = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employer, $job)
    {
        $this->employer = $employer;
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.employer.job_adopt')
            ->replyTo('official@job-cinema.com')
            ->subject('【JOBCiNEMA】求人票申請が承認されました');
    }
}
