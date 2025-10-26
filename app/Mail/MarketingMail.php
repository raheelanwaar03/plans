<?php

namespace App\Mail;

use Faker\Provider\ar_EG\Address;
use Faker\Provider\ar_JO\Address as Ar_JOAddress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MarketingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $bodyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $message)
    {
        $this->subjectLine = $subject;
        $this->bodyMessage = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            'from' =>
            [
                    'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                    'name' => env('MAIL_FROM_NAME', 'Example'),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return $this->subject($this->subjectLine)
            ->view('emails.marketing')
            ->with([
                'bodyMessage' => $this->bodyMessage,
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
