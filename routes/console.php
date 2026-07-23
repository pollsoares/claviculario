<?php

use Illuminate\Support\Facades\Schedule;

// Executa todos os dias úteis às 18:00
Schedule::command('keys:send-reminders')
    ->weekdays()
    ->at('12:00');
