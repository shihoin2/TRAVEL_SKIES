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
        Schema::create('weather', function (Blueprint $table) {
            $table->id();
            $table->string('city_name'); // 都市名
            $table->string('country'); // 国コード
            $table->double('lat', 8, 6); // 緯度
            $table->double('lon', 8, 6); // 経度
            $table->dateTime('weather_time'); // 天気の時刻
            $table->string('weather_main'); // 天気のメイン
            $table->string('weather_description'); // 天気の説明
            $table->string('weather_icon'); // 天気アイコン
            $table->float('temperature'); // 温度
            $table->float('feels_like'); // 体感温度
            $table->float('temp_min'); // 最低温度
            $table->float('temp_max'); // 最高温度
            $table->integer('pressure'); // 気圧
            $table->integer('humidity'); // 湿度
            $table->integer('visibility'); // 視界
            $table->float('wind_speed'); // 風速
            $table->integer('wind_deg'); // 風向き
            $table->float('rain_1h')->nullable(); // 1時間の雨量（任意）
            $table->integer('clouds_all'); // 雲量
            $table->timestamps(); // 作成・更新のタイムスタンプ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather');
    }
};
