<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array{name:string,email:string,phone:?string,subject:string,message:string}
     */
    public array $data;

    /**
     * @param array{name:string,email:string,phone:?string,subject:string,message:string} $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouveau message (Contact) : '.$this->data['subject'],
            replyTo: [
                new \Illuminate\Mail\Mailables\Address($this->data['email'], $this->data['name']),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form-submitted',
            with: ['data' => $this->data],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
