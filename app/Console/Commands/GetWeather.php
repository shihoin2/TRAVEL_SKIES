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
        $prefectures = [
            '北海道' => ['Sapporo', 'Asahikawa', 'Hakodate'],
            '青森県' => ['Aomori', 'Hachinohe'],
            '岩手県' => ['Morioka'],
            '宮城県' => ['Sendai'],
            '秋田県' => ['Akita'],
            '山形県' => ['Yamagata'],
            '福島県' => ['Fukushima'],
            '茨城県' => ['Mito'],
            '栃木県' => ['Utsunomiya'],
            '群馬県' => ['Maebashi'],
            '埼玉県' => ['Saitama'],
            '千葉県' => ['Chiba'],
            '東京都' => ['Tokyo'],
            '神奈川県' => ['Yokohama', 'Kawasaki'],
            '新潟県' => ['Niigata'],
            '富山県' => ['Toyama'],
            '石川県' => ['Kanazawa'],
            '福井県' => ['Fukui'],
            '山梨県' => ['Kofu'],
            '長野県' => ['Nagano'],
            '岐阜県' => ['Gifu'],
            '静岡県' => ['Shizuoka', 'Hamamatsu'],
            '愛知県' => ['Nagoya'],
            '三重県' => ['Tsu'],
            '滋賀県' => ['Otsu'],
            '京都府' => ['Kyoto'],
            '大阪府' => ['Osaka'],
            '兵庫県' => ['Kobe', 'Himeji'],
            '奈良県' => ['Nara'],
            '和歌山県' => ['Wakayama'],
            '鳥取県' => ['Tottori'],
            '島根県' => ['Matsue'],
            '岡山県' => ['Okayama'],
            '広島県' => ['Hiroshima'],
            '山口県' => ['Yamaguchi'],
            '徳島県' => ['Tokushima'],
            '香川県' => ['Takamatsu'],
            '愛媛県' => ['Matsuyama'],
            '高知県' => ['Kochi'],
            '福岡県' => ['Fukuoka', 'Kitakyushu'],
            '佐賀県' => ['Saga'],
            '長崎県' => ['Nagasaki'],
            '熊本県' => ['Kumamoto'],
            '大分県' => ['Oita'],
            '宮崎県' => ['Miyazaki'],
            '鹿児島県' => ['Kagoshima'],
            '沖縄県' => ['Naha']
        ];
        $apiKey = env('WEATHER_API_KEY');
        $geocodeBaseUrl = env('WEATHER_API_GEOCODE_BASE_URL');
        $weatherBaseUrl = env('WEATHER_API_BASE_URL');
        $country = 'JP';

        foreach ($prefectures as $prefecture => $cities) {
            foreach ($cities as $city) {
                $url = "{$geocodeBaseUrl}?q={$city},{$country}&limit=1&appid={$apiKey}";

                try {
                    $response = Http::get($url);
                    $data = $response->json();

                    if (!empty($data) && isset($data[0]['lat'], $data[0]['lon'])) {
                        $lat = $data[0]['lat'];
                        $lon = $data[0]['lon'];

                        // 天気情報を取得
                        $weatherUrl = "{$weatherBaseUrl}?lat={$lat}&lon={$lon}&appid={$apiKey}";
                            $weatherResponse = Http::get($weatherUrl);
                            $weatherData = $weatherResponse->json();

                            // データベースに保存
                            Weather::updateOrCreate(
                                ['city_name' => $weatherData['name'], 'country' => $weatherData['sys']['country']],
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
                        }
                } catch (\Exception $e) {
                    $this->error('データ取得に失敗しました: ' . $e->getMessage());
                }
            }
        }
        $this->info('天気データの取得が完了しました。');
    }
}
