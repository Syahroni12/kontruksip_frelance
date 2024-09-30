<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerivikasiAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    private $data;
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verivikasi Admin',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {

        if ($this->data == "aman") {
            return $this->view('mail.verifikasikliensetuju',[
                "status"=>$this->data,
               
                
            ]);
        } else {
            return $this->view('mail.verifikasiklientolak',[
                "status"=>$this->data,
               
                
            ]);
        }
        
        
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
