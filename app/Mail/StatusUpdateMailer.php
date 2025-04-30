<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusUpdateMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $status;
    public $statusMessage;
    
    public function __construct($name, $status, $statusMessage)
    {
        $this->name = $name;
        $this->status = $status;
        $this->statusMessage = $statusMessage;
    }
    

    public function build()
    {
        return $this->view('emails.statusUpdate')
                    ->with([
                        'name' => $this->name,
                        'status' => $this->status,
                        'statusMessage' => $this->statusMessage, // ✅ Updated
                    ])
                    ->subject("Application Status: " . $this->status);
    }
}
