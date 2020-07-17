<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContactMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected $content;
    protected $viewStr;

    /**
     * Create a new message instance.
     *
     * @param 
     */
    public function __construct($content, $viewStr = 'to')
    {
        $this->content = $content;
        $this->viewStr = $viewStr;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.'.$this->viewStr)
            ->to($this->content['to'], $this->content['to_name'])
            ->from($this->content['from'], $this->content['from_name'])
            ->replyTo($this->content['to_reply'])
            ->subject($this->content['subject'])
            ->with([
                'content' => $this->content,
            ]);
    }
}
