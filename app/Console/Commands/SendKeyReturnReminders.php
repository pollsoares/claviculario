<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KeyLoan;
use App\Notifications\ReturnKeyReminderNotification;

class SendKeyReturnReminders extends Command
{
    protected $signature = 'keys:send-reminders';
    protected $description = 'Envia e-mail de cobrança para quem não devolveu a chave no fim do dia';

    public function handle()
    {
        // Busca todos os empréstimos que ainda NÃO foram devolvidos
        $pendingLoans = KeyLoan::with(['user', 'key'])
            ->whereNull('returned_at')
            ->get();

        foreach ($pendingLoans as $loan) {
            // Dispara o e-mail para o profissional
            $loan->user->notify(new ReturnKeyReminderNotification($loan));
        }

        $this->info("Notificações enviadas para {$pendingLoans->count()} profissionais.");
    }
}
