<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobAppliedEmployer extends Mailable
{
    use Queueable, SerializesModels;

    public $appUser = [];
    public $jobId = [];
    public $jobAppData = [];
    public $company = [];
    public $employer = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appUser, $jobId, $jobAppData, $company, $employer)
    {
        $this->title = sprintf($jobId->job_office.'に求人応募がありました！
        ');
        $this->appUser = $appUser;
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
        ->view('emails.employer.job_applied');
        
    }
}
