<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $messageContent;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->subject = $data['subject'];
        $this->messageContent = $data['message'];
    }

    public function build()
    {
        return $this->markdown('emails.contact')
                   ->subject($this->subject)
                   ->from(config('mail.from.address'), config('mail.from.name'))
                   ->replyTo($this->email, $this->name);
    }
}