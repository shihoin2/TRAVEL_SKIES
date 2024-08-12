<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyWeather extends Model
{
    use HasFactory;

    protected $fillable = [
            'id',
            'city_name', // 都市名
            // 'country', // 国コード
            'lat', // 緯度
            'lon', // 経度
            'weather_time', // 天気の時刻（dt）
            'sunrise', // 日の出
            'sunset', // 日の入り
            'moonrise', // 月の出
            'moonset', // 月の入り
            'moon_phase', // 月のフェーズ
            'summary', // 天気の要約
            'temp_day', // 日中の温度
            'temp_min', // 最低温度
            'temp_max', // 最高温度
            'temp_night', // 夜の温度
            'temp_eve', // 夕方の温度
            'temp_morn', // 朝の温度
            'feels_like_day', // 日中の体感温度
            'feels_like_night', // 夜の体感温度
            'feels_like_eve', // 夕方の体感温度
            'feels_like_morn', // 朝の体感温度
            'pressure', // 気圧
            'humidity', // 湿度
            'dew_point', // 露点
            'wind_speed', // 風速
            'wind_deg', // 風向き
            'wind_gust', // 突風の速度
            'weather_main', // 天気のメイン
            'weather_description', // 天気の説明
            'weather_icon', // 天気アイコン
            'clouds', // 雲量
            'pop', // 降水確率
            'rain', // 降水量（任意）
            'uvi', // 紫外線インデックス
            'created_at',
            'updated_at',// 作成・更新のタイムスタンプ
    ];
}
