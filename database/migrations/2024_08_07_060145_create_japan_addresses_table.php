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
        Schema::create('japan_addresses', function (Blueprint $table) {
            $table->integer('id')->primary(); // 住所コード
            $table->integer('ken_id'); // 都道府県コード
            $table->integer('city_id'); // 市区町村コード
            $table->integer('town_id'); // 町域コード
            $table->string('zip', 8); // 郵便番号
            $table->tinyInteger('office_flg'); // 事業所フラグ
            $table->tinyInteger('delete_flg'); // 廃止フラグ
            $table->string('ken_name', 8); // 都道府県
            $table->string('ken_furi', 8); // 都道府県カナ
            $table->string('city_name', 24); // 市区町村
            $table->string('city_furi', 24); // 市区町村カナ
            $table->string('town_name', 32); // 町域
            $table->string('town_furi', 32); // 町域カナ
            $table->string('town_memo', 16)->nullable(); // 町域補足
            $table->string('kyoto_street', 32)->nullable(); // 京都通り名
            $table->string('block_name', 64)->nullable(); // 字丁目
            $table->string('block_furi', 64)->nullable(); // 字丁目カナ
            $table->string('memo', 255)->nullable(); // 補足
            $table->string('office_name', 255)->nullable(); // 事業所名
            $table->string('office_furi', 255)->nullable(); // 事業所名カナ
            $table->string('office_address', 255)->nullable(); // 事業所住所
            // $table->integer('new_id')->nullable()->default(null); // 新住所CD
            $table->string('new_id')->nullable(); // 新住所CD
            $table->timestamps(); // 作成・更新のタイムスタンプ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('japan_addresses');
    }
};
