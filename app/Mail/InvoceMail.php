<?php

namespace App\Mail;

use Faker\Provider\ar_EG\Address;
use Generator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $invoce;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoce, $details)
    {
        $this->invoce = $invoce;
        $this->details = $details;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Invoice Detail Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        
        return new Content(
            view: 'mails.invoce',
            with: [
                'invoce' => $this->invoce,
                'details' => $this->details
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
