<?php

use Illuminate\Support\Facades\Schedule;

// Executa todos os dias úteis às 12:00
Schedule::command('keys:send-reminders')
    ->weekdays()
    ->at('17:10');
