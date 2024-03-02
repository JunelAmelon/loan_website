<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemandeInfoMarkdownMail extends Mailable
{
    use Queueable, SerializesModels;
    public $prenom;
    public $nom;
    /**
     * Create a new message instance.
     */
    public function __construct($prenom, $nom)
    {
        $this->prenom = $prenom;
        $this->nom = $nom;
    }

    public function build()
    {
        return $this->from("informace@socialnipujcka.cz")
                    ->subject("Nová žádost přijata")
                    ->markdown('emails.markdowndemandeinfo')
                    ->with([
                        'prenom' => $this->prenom,
                        'nom' => $this->nom,
                    ]);
    }
}
