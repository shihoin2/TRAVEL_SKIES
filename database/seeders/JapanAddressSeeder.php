<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class JapanAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/sql/zenkoku.sql');  // 修正したSQLファイルのパス
        $sql = File::get($path);
        try {
            DB::unprepared($sql);
        } catch (\Exception $e) {
            \Log::error('SQL Import Failed: ' . $e->getMessage());
            throw $e; // エラーが発生したらそのまま再スロー
        }
    }
}
