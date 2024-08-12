<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_weather', function (Blueprint $table) {
            $table->id();
            $table->string('city_name'); // 都市名
            // $table->string('country'); // 国コード
            $table->double('lat', 8, 6); // 緯度
            $table->double('lon', 8, 6); // 経度
            $table->dateTime('weather_time'); // 天気の時刻（dt）
            $table->dateTime('sunrise'); // 日の出
            $table->dateTime('sunset'); // 日の入り
            $table->dateTime('moonrise'); // 月の出
            $table->dateTime('moonset'); // 月の入り
            $table->float('moon_phase'); // 月のフェーズ
            $table->string('summary'); // 天気の要約
            $table->float('temp_day'); // 日中の温度
            $table->float('temp_min'); // 最低温度
            $table->float('temp_max'); // 最高温度
            $table->float('temp_night'); // 夜の温度
            $table->float('temp_eve'); // 夕方の温度
            $table->float('temp_morn'); // 朝の温度
            $table->float('feels_like_day'); // 日中の体感温度
            $table->float('feels_like_night'); // 夜の体感温度
            $table->float('feels_like_eve'); // 夕方の体感温度
            $table->float('feels_like_morn'); // 朝の体感温度
            $table->integer('pressure'); // 気圧
            $table->integer('humidity'); // 湿度
            $table->float('dew_point'); // 露点
            $table->float('wind_speed'); // 風速
            $table->integer('wind_deg'); // 風向き
            $table->float('wind_gust')->nullable(); // 突風の速度
            $table->string('weather_main'); // 天気のメイン
            $table->string('weather_description'); // 天気の説明
            $table->string('weather_icon'); // 天気アイコン
            $table->integer('clouds'); // 雲量
            $table->float('pop'); // 降水確率
            $table->float('rain')->nullable(); // 降水量（任意）
            $table->float('uvi'); // 紫外線インデックス
            $table->timestamps(); // 作成・更新のタイムスタンプ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_weather');
    }
};
