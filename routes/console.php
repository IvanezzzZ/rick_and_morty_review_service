<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

Schedule::command('sync:episodes')
    ->weekdays()
    ->hourly()
    ->timezone('Europe/Moscow')
    ->between('8:00', '22:00');
