<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodeResetMarkdownMail extends Mailable
{
    use Queueable, SerializesModels;
    public $resetCode;
    public $email;
    /**
     * Create a new message instance.
     */
    public function __construct($resetCode, $email)
    {
        $this->resetCode = $resetCode;
        $this->email = $email;
    }

    public function build()
    {
        return $this->from("informace@socialnipujcka.cz")
                    ->subject("Resetovat heslo")
                    ->markdown('emails.markdowncodereset')
                    ->with([
                        'CodeReset' => $this->resetCode,
                    ]);
    }
}
