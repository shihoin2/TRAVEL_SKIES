<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class WeatherController extends Controller
{
    public function getPrefectureWeather(Request $request)
    {
        $prefecture = $request->input('prefecture');

        $cities = $this->getCityForPrefecture($prefecture);
        $prefectureWeatherData = [];

        foreach ($cities as $city) {
            $weatherData = DB::table('weather')->where('city_name', $city)->get();

            foreach ($weatherData as $data) {
                $prefectureWeatherData[] = [
                    'city_name' => $data->city_name,
                    'weather' => [
                        'main' => $data->weather_main,
                        'description' => $data->weather_description,
                        'icon' => $data->weather_icon,
                        'temperature' => $data->temperature,
                        'feels_like' => $data->feels_like,
                        'temp_min' => $data->temp_min,
                        'temp_max' => $data->temp_max,
                        'pressure' => $data->pressure,
                        'humidity' => $data->humidity,
                        'visibility' => $data->visibility,
                        'wind_speed' => $data->wind_speed,
                        'wind_deg' => $data->wind_deg,
                        'clouds_all' => $data->clouds_all,
                        'rain_1h' => $data->rain_1h,
                        'weather_time' => $data->weather_time,
                    ]
                ];
            }
        }
        return response()->json($prefectureWeatherData);
    }

    public function getCityWeather(Request $request)
    {
        $city = $request->input('city');
        $cityDailyWeatherData = [];
        $cityCurrentWeatherData = [];

        $currentWeatherData = DB::table('weather')->where('city_name', $city)->get();
        foreach ($currentWeatherData as $currentData) {
            $cityCurrentWeatherData[] = [
                'city_name' => $currentData->city_name,
                'weather' => [
                    'main' => $currentData->weather_main,
                    'description' => $currentData->weather_description,
                    'icon' => $currentData->weather_icon,
                    'temperature' => $currentData->temperature,
                    'feels_like' => $currentData->feels_like,
                    'temp_min' => $currentData->temp_min,
                    'temp_max' => $currentData->temp_max,
                    'pressure' => $currentData->pressure,
                    'humidity' => $currentData->humidity,
                    'visibility' => $currentData->visibility,
                    'wind_speed' => $currentData->wind_speed,
                    'wind_deg' => $currentData->wind_deg,
                    'clouds_all' => $currentData->clouds_all,
                    'rain_1h' => $currentData->rain_1h,
                    'weather_time' => $currentData->weather_time,
                ]
            ];
        }

        // $tomorrow = Carbon::tomorrow()->startOfDay();
        $dailyWeatherData = DB::table('daily_weather')
        ->where('city_name', $city)
        // ->where('weather_time', '>=', $tomorrow)
        ->get();

        foreach ($dailyWeatherData as $data) {
                $cityDailyWeatherData[] = [
                    'city_name' => $data->city_name,
                    'weather' => [
                        'main' => $data->weather_main,
                        'description' => $data->weather_description,
                        'icon' => $data->weather_icon,
                        'temp_day' => $data->temp_day,
                        'feels_like_day' => $data->feels_like_day,
                        'feels_like_night' => $data->feels_like_night,
                        'feels_like_eve' => $data->feels_like_eve,
                        'feels_like_morn' => $data->feels_like_morn,
                        'temp_min' => $data->temp_min,
                        'temp_max' => $data->temp_max,
                        'pressure' => $data->pressure,
                        'humidity' => $data->humidity,
                        'wind_speed' => $data->wind_speed,
                        'wind_deg' => $data->wind_deg,
                        'clouds' => $data->clouds,
                        'rain' => $data->rain,
                        'pop' => $data->pop,
                        'weather_time' => $data->weather_time,
                        'updated_at' => $data->updated_at,
                    ]
                ];
        }
        return response()->json([
            'current_weather' => $cityCurrentWeatherData,
            'daily_weather' => $cityDailyWeatherData,
        ]);
    }

    private function getCityForPrefecture($prefecture)
    {
        $cities = [
            '北海道' => ['札幌市', '旭川市', '函館市'],
            '青森県' => ['青森市', '八戸市'],
            '岩手県' => ['盛岡市'],
            '宮城県' => ['仙台市'],
            '秋田県' => ['秋田市'],
            '山形県' => ['山形市'],
            '福島県' => ['福島市'],
            '茨城県' => ['水戸市'],
            '栃木県' => ['宇都宮市'],
            '群馬県' => ['前橋市'],
            '埼玉県' => ['さいたま市'],
            '千葉県' => ['千葉市'],
            '東京都' => ['調布市'],
            '神奈川県' => ['横浜市', '川崎市'],
            '新潟県' => ['新潟市'],
            '富山県' => ['富山市'],
            '石川県' => ['金沢市'],
            '福井県' => ['福井市'],
            '山梨県' => ['甲府市'],
            '長野県' => ['長野市'],
            '岐阜県' => ['岐阜市'],
            '静岡県' => ['静岡市', '浜松市'],
            '愛知県' => ['名古屋市'],
            '三重県' => ['津市'],
            '滋賀県' => ['大津市'],
            '京都府' => ['京都市'],
            '大阪府' => ['大阪市'],
            '兵庫県' => ['神戸市', '姫路市'],
            '奈良県' => ['奈良市'],
            '和歌山県' => ['和歌山市'],
            '鳥取県' => ['鳥取市'],
            '島根県' => ['松江市'],
            '岡山県' => ['岡山市'],
            '広島県' => ['広島市'],
            '山口県' => ['山口市'],
            '徳島県' => ['徳島市'],
            '香川県' => ['高松市'],
            '愛媛県' => ['松山市'],
            '高知県' => ['高知市'],
            '福岡県' => ['福岡市', '北九州市'],
            '佐賀県' => ['佐賀市'],
            '長崎県' => ['長崎市'],
            '熊本県' => ['熊本市'],
            '大分県' => ['大分市'],
            '宮崎県' => ['宮崎市'],
            '鹿児島県' => ['鹿児島市'],
            '沖縄県' => ['那覇市']
        ];
        return $cities[$prefecture] ?? [];
    }
}
