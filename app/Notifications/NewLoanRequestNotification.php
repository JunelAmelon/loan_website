<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLoanRequestNotification extends Notification
{
    use Queueable;

    protected $demande;

    public function __construct($demande)
    {
        $this->demande = $demande;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle demande de prêt')
            ->line('Une nouvelle demande de prêt a été soumise.')
            ->action('Voir la demande', url('/admin/view_loan_requests'))
            ->line('Merci de traiter cette demande.');
    }

    public function toArray($notifiable)
    {
        return [
            // ...
        ];
    }
}
