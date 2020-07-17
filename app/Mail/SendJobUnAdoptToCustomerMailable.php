<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendJobUnAdoptToCustomerMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $employer = [];
    public $job = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job)
    {
        $this->employer = $job->employer;
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.employer.job_unadopt')
            ->replyTo('official@job-cinema.com')
            ->subject('【JOBCiNEMA】求人票申請が否認されました');
    }
}
