<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\DailyWeather;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GetEightDayWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:get8d';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '8日間の天気予報情報を取得し、データベースに保存';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prefectures = config('prefectures');
        $apiKey = env('WEATHER_API_KEY');
        $geocodeBaseUrl = env('WEATHER_API_GEOCODE_BASE_URL');
        $weatherBaseUrl = env('WEATHER_API_ONECALL_BASE_URL');
        $country = 'JP';
        $exclude = 'current,minutely,hourly';

        foreach ($prefectures as $prefecture => $cities) {
            foreach ($cities as $city) {
                $url = "{$geocodeBaseUrl}?q={$city},{$prefecture},{$country}&limit=1&appid={$apiKey}";
                try {
                    $response = Http::get($url);
                    $data = $response->json();

                    if (!empty($data) && isset($data[0]['lat'], $data[0]['lon'])) {
                        $lat = $data[0]['lat'];
                        $lon = $data[0]['lon'];

                        $dailyWeatherUrl = "{$weatherBaseUrl}?lat={$lat}&lon={$lon}&exclude={$exclude}&appid={$apiKey}&lang=ja&units=metric";
                        $dailyWeatherResponse = Http::get($dailyWeatherUrl);
                        $dailyWeatherData = $dailyWeatherResponse->json();

                        // foreach ($dailyWeatherData['daily'] as $dayData) {
                        foreach ($dailyWeatherData['daily'] as $dayData) {
                            $weather = $dayData['weather'][0] ?? [];

                            DailyWeather::updateOrCreate(
                                [
                                    'city_name' => $data[0]['local_names']['ja'],
                                    // 'city_name' => $city,
                                    // 'prefecture' => $prefecture,
                                    'lat' => $lat,
                                    'lon' => $lon,
                                    'weather_time' => Carbon::createFromTimestamp($dayData['dt'], 'Asia/Tokyo')->toDateTimeString()
                                ],
                                [
                                    'sunrise' => Carbon::createFromTimestamp($dayData['sunrise'], 'Asia/Tokyo')->toDateTimeString(),
                                    'sunset' => Carbon::createFromTimestamp($dayData['sunset'], 'Asia/Tokyo')->toDateTimeString(),
                                    'moonrise' => Carbon::createFromTimestamp($dayData['moonrise'], 'Asia/Tokyo')->toDateTimeString(),
                                    'moonset' => Carbon::createFromTimestamp($dayData['moonset'], 'Asia/Tokyo')->toDateTimeString(),
                                    'moon_phase' => $dayData['moon_phase'],
                                    'summary' => $dayData['summary'],
                                    'temp_day' => $dayData['temp']['day'],
                                    'temp_min' => $dayData['temp']['min'],
                                    'temp_max' => $dayData['temp']['max'],
                                    'temp_night' => $dayData['temp']['night'],
                                    'temp_eve' => $dayData['temp']['eve'],
                                    'temp_morn' => $dayData['temp']['morn'],
                                    'feels_like_day' => $dayData['feels_like']['day'],
                                    'feels_like_night' => $dayData['feels_like']['night'],
                                    'feels_like_eve' => $dayData['feels_like']['eve'],
                                    'feels_like_morn' => $dayData['feels_like']['morn'],
                                    'pressure' => $dayData['pressure'],
                                    'humidity' => $dayData['humidity'],
                                    'dew_point' => $dayData['dew_point'],
                                    'wind_speed' => $dayData['wind_speed'],
                                    'wind_deg' => $dayData['wind_deg'],
                                    'wind_gust' => $dayData['wind_gust'] ?? null, // 突風の速度
                                    'weather_main' => $weather['main'],
                                    'weather_description' => $weather['description'],
                                    'weather_icon' => $weather['icon'],
                                    'clouds' => $dayData['clouds'],
                                    'pop' => $dayData['pop'],
                                    'rain' => $dayData['rain'] ?? null, // 降水量（任意）
                                    'uvi' => $dayData['uvi'],
                                ]
                            );
                        }
                    } else {
                        $this->error("ジオコード情報が見つかりませんでした: {$city}, {$prefecture}");
                    }
                } catch (\Exception $e) {
                    $this->error('データ取得に失敗しました: ' . $e->getMessage());
                }
            }
        }
        $this->info('天気データの取得が完了しました。');
        $this->info('Updating weather for: ' . $data[0]['local_names']['ja']);

        $DaysAgo = Carbon::now()->subDays(3);
        DailyWeather::where('weather_time', '<', $DaysAgo)->delete();

        $DeleteMessage = $DaysAgo->format('Y-m-d') . '以前の天気情報を削除しました。';
        $this->info($DeleteMessage);
    }
}
