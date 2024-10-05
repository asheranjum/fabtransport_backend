<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormsAttachmentsMail extends Mailable
{
    use Queueable, SerializesModels;
    public $PostData;
    public $pdf;
    public $subject;
    public $viewName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($PostData, $pdf, $subject,$viewName)
    {
        $this->PostData = $PostData;
        $this->pdf = $pdf;
        $this->subject = $subject;
        $this->viewName = $viewName;
    }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: 'Get House Moving Form Mail',
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
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */

     public function build()
     {
         return $this->view($this->viewName) // make sure you have the correct view file
             ->subject($this->subject)
             ->with(['PostData' => $this->PostData]) // pass the postData variable to the view
             ->attachData($this->pdf->output(), 'quote.pdf', [
                 'mime' => 'application/pdf',
             ]);
     }

}
