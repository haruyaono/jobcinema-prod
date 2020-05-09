<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobAppliedSeeker extends Mailable
{
    use Queueable, SerializesModels;

    public $title = [];
    public $jobId = [];
    public $jobAppData = [];
    public $company = [];
    public $employer = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobId, $jobAppData, $company, $employer)
    {
        $this->title = sprintf($jobId->job_office.'への応募が完了しました！
        ');
        $this->jobId = $jobId;
        $this->jobAppData = $jobAppData;
        $this->company = $company;
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
        ->subject($this->title)
        ->replyTo('official@job-cinema.com')
        ->view('emails.seeker.job_applied');
    }
}
