<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobAppliedEmployer extends Mailable
{
    use Queueable, SerializesModels;

    public $title = [];
    public $jobitem = [];
    public $data = [];
    public $company = [];
    public $employer = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobitem, $data)
    {
        $this->title = sprintf($jobitem->job_office . 'に求人応募がありました！');
        $this->jobitem = $jobitem;
        $this->data = $data;
        $this->company = $jobitem->company;
        $this->employer = $jobitem->company->employer;
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
            ->replyTo(config('mail.reply.address'))
            ->view('emails.employer.job_applied');
    }
}
