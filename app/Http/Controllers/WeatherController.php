<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getPrefectureWeather(Request $request)
    {
        $prefecture = $request->input('prefecture');
        $country = $request->input('country', 'JP');
        $apiKey = env('WEATHER_API_KEY');
        $baseUrl = env('WEATHER_API_GEOCODE_BASE_URL');
        $weatherBaseUrl = env('WEATHER_API_BASE_URL');


        if (!$prefecture) {
            return response()->json(['error' => '都道府県名は必須です!'], 400);
        }

        $cities = $this->getCityForPrefecture($prefecture);
        $weatherData = [];

        foreach ($cities as $city) {
            $url = "{$baseUrl}?q={$city},{$country}&limit=1&appid={$apiKey}";

            try {
                $response = Http::get($url);
                $data = $response->json();

                if (!empty($data)) {
                    $lat = $data[0]['lat'];
                    $lon = $data[0]['lon'];



                    // 天気情報を取得
                    $weatherUrl = "{$weatherBaseUrl}?lat={$lat}&lon={$lon}&appid={$apiKey}";
                    $weatherResponse = Http::get($weatherUrl);
                    $weatherData[] = [
                        'city' => $city,
                        'weather' => $weatherResponse->json()
                    ];
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'データ取得に失敗しました'], 500);
            }
        }

        return response()->json($weatherData);
    }


    private function getCityForPrefecture($prefecture)
    {
        // 都道府県に基づいて特定の市を決定するロジックをここに追加
        // 例えば、最初の市を返すなど
        $cities = [
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
        return $cities[$prefecture] ?? [];
    }
}
