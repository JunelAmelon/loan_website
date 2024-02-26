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
    public $nom;
    public $prenom;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($montantMensuel, $dureeAnnees, $montantDemande, $montant_restant, $nom, $prenom, $email)
    {
        $this->montantMensuel = $montantMensuel;
        $this->dureeAnnees = $dureeAnnees;
        $this->montantDemande = $montantDemande;
        $this->montant_restant = $montant_restant;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
    }

    public function build()
    {
        return $this->from("pret@Noreply.com")
                    ->subject("Žádost byla ověřena")
                    ->markdown('emails.markdownvalide')
                    ->with([
                        'prenom' => $this->prenom,
                        'nom' => $this->nom,
                        'montantMensuel' => $this->montantMensuel,
                        'dureeAnnees' => $this->dureeAnnees,
                        'montantDemande'=> $this->montantDemande,
                        'montant_restant'=> $this->montant_restant,
                    ]);
    }
}
