<?php

namespace App\Notifications;

use App\Models\KeyLoan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReturnKeyReminderNotification extends Notification
{
    use Queueable;

    public $loan;

    public function __construct(KeyLoan $loan)
    {
        $this->loan = $loan;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Lembrete: Devolução de Chave Pendente')
            ->greeting("Olá, {$notifiable->name}!")
            ->line("Identificamos que você retirou a chave da **Sala {$this->loan->key->room_number}** hoje às {$this->loan->borrowed_at->format('H:i')}.")
            ->line('Por favor, lembre-se de devolver a chave na portaria/recepção antes de encerrar o expediente.')
            ->salutation('Atenciosamente, Administração do Prédio');
    }
}
