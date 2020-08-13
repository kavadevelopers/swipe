<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailFromAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $mailData)
    {
        $this->user = $user;
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailData->subject)
                    ->view('emails.mail-from-admin')
                    ->with([
                        'user' => $this->user,
                        'mailData' => $this->mailData,
                    ]);
    }
}
