<?php

use App\Http\Controllers\JapanAddressController;
use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('travel_skies')
->controller(WeatherController::class)
->group(function () {
    Route::get('/get_prefecture_locale', 'getPrefectureLocale')->name('getPrefectureLocale');
    Route::get('/get_prefecture_weather', 'getPrefectureWeather')->name('getPrefectureWeather');
});

Route::prefix('travel_skies')
->controller(JapanAddressController::class)
->group(function () {
    Route::get('/get_prefecture', 'getPrefecture')->name('getPrefecture');
});
