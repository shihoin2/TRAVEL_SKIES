<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'city_name',
        'country',
        'lat',
        'lon',
        'weather_time',
        'weather_main',
        'weather_description',
        'weather_icon',
        'temperature',
        'feels_like',
        'temp_min',
        'temp_max',
        'pressure',
        'humidity',
        'visibility',
        'wind_speed',
        'wind_deg',
        'rain_1h',
        'clouds_all',
        'created_at',
        'updated_at',
    ];
}
