<?php

namespace App\Mail\Employer;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $apply;
    public $mail;
    public $flag;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($apply, $flag, $mail = '')
    {
        $this->flag = $flag;
        $this->subject = '【JOB CiNEMA】選考結果のご連絡（' . $apply->jobitem->company->cname . '）の採用通知';
        $this->apply = $apply;
        $this->mail = $this->createMail($apply, $flag, $mail);
    }

    private function createMail($apply, $flag, $mail)
    {
        if ($flag == 'adopt') {
            return;
        }

        $text = '';

        switch ($flag) {
            case '応募者から辞退':
                $text = $apply->detail->full_name . '様のご辞退を承りました。';
                break;
            case '応募者と連絡が取れない':
                $text = $apply->detail->full_name . '様とうまく連絡が取れないため、選考辞退とさせていただきます。';
                break;
            case '採用の定員に達した':
                $text = '採用の定員に達したため、採用活動を終了します。';
                break;
            default:
                $text = $mail;
                break;
        }

        return $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.employer.application.report')
            ->replyTo(config('mail.reply.address'))
            ->subject($this->subject);
    }
}
