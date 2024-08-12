<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Weather;
use Illuminate\Support\Carbon;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '天気情報を定期的にデータベースに保存';
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
        $weatherBaseUrl = env('WEATHER_API_BASE_URL');
        $country = 'JP';

        foreach ($prefectures as $prefecture => $cities) {
            foreach ($cities as $city) {
                $url = "{$geocodeBaseUrl}?q={$city},{$prefecture},{$country}&limit=1&appid={$apiKey}";
                // $url = "{$geocodeBaseUrl}?q={$city},{$prefecture},{$country}&limit=1&appid={$apiKey}&lang=ja";

                try {
                    $response = Http::get($url);
                    $data = $response->json();

                    if (!empty($data) && isset($data[0]['lat'], $data[0]['lon'])) {
                        $lat = $data[0]['lat'];
                        $lon = $data[0]['lon'];

                        // 天気情報を取得
                        // $weatherUrl = "{$weatherBaseUrl}?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric";
                        $weatherUrl = "{$weatherBaseUrl}?lat={$lat}&lon={$lon}&appid={$apiKey}&lang=ja&units=metric";
                            $weatherResponse = Http::get($weatherUrl);
                            $weatherData = $weatherResponse->json();

                            if (isset($weatherData['sys']['country'])) {
                            // データベースに保存
                            Weather::updateOrCreate(
                                // ['city_name' => $weatherData['name'], 'country' => $weatherData['sys']['country']],
                                ['city_name' => $data[0]['local_names']['ja'], 'country' => $weatherData['sys']['country']],
                                [
                                    'lat' => $weatherData['coord']['lat'],
                                    'lon' => $weatherData['coord']['lon'],
                                    'weather_time' => Carbon::createFromTimestamp($weatherData['dt'], 'Asia/Tokyo')->toDateTimeString(),
                                    // 'weather_time' => Carbon::createFromTimestamp($weatherData['dt'])->addHours(9)->toDateTimeString(),
                                    'weather_main' => $weatherData['weather'][0]['main'],
                                    'weather_description' => $weatherData['weather'][0]['description'],
                                    'weather_icon' => $weatherData['weather'][0]['icon'],
                                    'temperature' => $weatherData['main']['temp'],
                                    'feels_like' => $weatherData['main']['feels_like'],
                                    'temp_min' => $weatherData['main']['temp_min'],
                                    'temp_max' => $weatherData['main']['temp_max'],
                                    'pressure' => $weatherData['main']['pressure'],
                                    'humidity' => $weatherData['main']['humidity'],
                                    'visibility' => $weatherData['visibility'],
                                    'wind_speed' => $weatherData['wind']['speed'],
                                    'wind_deg' => $weatherData['wind']['deg'],
                                    'clouds_all' => $weatherData['clouds']['all'],
                                    'rain_1h' => $weatherData['rain']['1h'] ?? null,  // 雨量がない場合は null
                                ]
                            );
                            $this->info('Updating weather for: ' . $weatherData['name']);
                        } else {
                            $this->error("天気情報に国コードが見つかりませんでした: {$city}, {$prefecture}");
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
    }
}
