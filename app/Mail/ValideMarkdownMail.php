<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ValideMarkdownMail extends Mailable
{
    use Queueable, SerializesModels;
    public $montantMensuel;
    public $dureeAnnees;
    public $montantDemande;
    public $montant_restant;
    public $name;
    public $prenom;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($montantMensuel, $dureeAnnees, $montantDemande, $montant_restant, $name, $prenom, $email)
    {
        $this->montantMensuel = $montantMensuel;
        $this->dureeAnnees = $dureeAnnees;
        $this->montantDemande = $montantDemande;
        $this->montant_restant = $montant_restant;
        $this->name = $name;
        $this->prenom = $prenom;
        $this->email = $email;
    }

    public function build()
    {
        return $this->from("informace@socialnipujcka.cz")
                    ->subject("Žádost byla ověřena")
                    ->markdown('emails.markdownvalide')
                    ->with([
                        'prenom' => $this->prenom,
                        'name' => $this->name,
                        'montantMensuel' => $this->montantMensuel,
                        'dureeAnnees' => $this->dureeAnnees,
                        'montantDemande'=> $this->montantDemande,
                        'montant_restant'=> $this->montant_restant,
                    ]);
    }
}
