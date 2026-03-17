<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('migrar:llamadas')
    ->monthlyOn(1, '00:00') // Se ejecuta el día 1 de cada mes a las 00:00
    ->runInBackground()
    ->onOneServer();
