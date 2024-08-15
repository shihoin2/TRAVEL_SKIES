<?php

namespace App\Http\Controllers;

use App\Models\JapanAddress;
use Illuminate\Http\Request;

class JapanAddressController extends Controller
{
    public function getPrefecture(Request $request) {
        $uniquePrefectureNames = JapanAddress::select('ken_name')
        ->distinct()
        ->get();

        $regions = [
            '北海道' => ['北海道'],
            '東北' => ['青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県'],
            '関東・甲信' => ['茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '山梨県', '長野県'],
            '北陸' => ['新潟県', '富山県', '石川県', '福井県'],
            '東海' => ['岐阜県', '静岡県', '愛知県','三重県'],
            '近畿' => ['滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県'],
            '中国' => ['鳥取県', '島根県', '岡山県', '広島県', '山口県'],
            '四国' => ['徳島県', '香川県', '愛媛県', '高知県'],
            '九州' => ['福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県'],
            '沖縄' => ['沖縄県']
        ];

	$groupePrefectureNames = [];

	//追加

	foreach ($regions as $region => $prefectureNames) {
        $groupePrefectureNames[$region] = [];
	}
	////

        foreach ($uniquePrefectureNames as $prefecture) {
            foreach ($regions as $region => $prefectureNames) {
                if (in_array($prefecture->ken_name, $prefectureNames)) {
                    $groupePrefectureNames[$region][] = $prefecture->ken_name;
                    break;
                }
            }
	}
	 // 地域の順序を保証するために、`$regions` の順序で結果を整列
    $sortedGroupePrefectureNames = [];
    foreach (array_keys($regions) as $region) {
        if (isset($groupePrefectureNames[$region])) {
            $sortedGroupePrefectureNames[$region] = $groupePrefectureNames[$region];
        }
    }
	return response()->json($sortedGroupePrefectureNames);
    }
}
