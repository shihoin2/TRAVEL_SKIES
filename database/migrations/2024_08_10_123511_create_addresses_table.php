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
        Schema::create('addresses', function (Blueprint $table) {
            // $table->id();
            $table->string('prefecture_code'); // 都道府県コード
            $table->string('prefecture_name'); // 都道府県名
            $table->string('municipality_code'); // 市区町村コード
            $table->string('municipality_name'); // 市区町村名
            $table->string('town_block_code'); // 大字町丁目コード
            $table->string('town_block_name'); // 大字・町丁目名
            $table->decimal('latitude', 9, 6); // 緯度
            $table->decimal('longitude', 9, 6); // 経度
            $table->string('reference_material_code'); // 原典資料コード
            $table->string('town_type_code'); // 大字・字・丁目区分コード
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
