<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
// use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\GetWeather;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

// Artisan::command('weather:get', function () {
//     Log::info('天気予報データを取得しデータベースに保存しました。');
// })->purpose('天気予報データを取得&登録')->everyTenSeconds();
Schedule::command('weather:get')->everyThirtyMinutes();
// Schedule::command('weather:get8d')->everyFiveMinutes();
// Schedule::command('weather:get8d')->everySixHours($minutes = 0);
Schedule::command('weather:get8d')->daily();
