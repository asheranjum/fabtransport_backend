<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GetQuoteMail extends Mailable
{
    use Queueable, SerializesModels;
    public $postData;
    public $pdf;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($postData, $pdf)
    {
        $this->postData = $postData;
        $this->pdf = $pdf;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: 'Get Quote Mail',
    //     );
    // }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    // public function content()
    // {
    //     return new Content(
    //         view: 'email.getQuoteMail',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    // public function attachments()
    // {
    //     return [];
    // }

 

    public function build()
    {
        return $this->view('email.getQuoteMail') // make sure you have the correct view file
            ->subject('Your Quote Request')
            ->with(['PostData' => $this->postData]) // pass the postData variable to the view
            ->attachData($this->pdf->output(), 'quote.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
