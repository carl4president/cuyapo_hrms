<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $password;

    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password; // This will now be the plain password
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to the Company!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.emailemployee',  // Create this view to format your email
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,  // Pass the plain password to the email view
                
            ],
        );
    }
    
}

