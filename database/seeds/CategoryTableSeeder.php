<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => '雇用形態',
                'slug' => 'status',
                'children' => [
                    [
                        'name' => '未登録',
                        'slug' => 'unregistered',
                        'sort' => 0,

                    ],
                    [
                        'name' => 'パート・アルバイト',
                        'sort' => 5,
                    ],
                    [
                        'name' => 'ナイトパート・アルバイト',
                        'sort' => 10,
                    ],
                    [
                        'name' => '正社員',
                        'sort' => 15,
                    ],
                    [
                        'name' => 'ナイト正社員',
                        'sort' => 20,
                    ]
                ],
            ],
            [
                'name' => '職種',
                'slug' => 'type',
                'children' => [
                    [
                        'name' => '未登録',
                        'slug' => 'unregistered',
                        'sort' => 0,

                    ],
                    [
                        'name' => '事務・オフィス',
                        'sort' => 5,
                    ],
                    [
                        'name' => '飲食・フード',
                        'sort' => 10,
                    ],
                    [
                        'name' => '販売・接客・サービス',
                        'sort' => 15,
                    ],
                    [
                        'name' => 'アパレル・ファッション',
                        'sort' => 20,
                    ],
                    [
                        'name' => '美容・エステ',
                        'sort' => 25,
                    ],
                    [
                        'name' => 'エンタメ・アミューズメント',
                        'sort' => 30,
                    ],
                    [
                        'name' => '営業',
                        'sort' => 35,
                    ],
                    [
                        'name' => 'Web・クリエイティブ',
                        'sort' => 40,
                    ],
                    [
                        'name' => 'IT・エンジニア',
                        'sort' => 45,
                    ],
                    [
                        'name' => '教育',
                        'sort' => 50,
                    ],
                    [
                        'name' => '医療・介護・保育',
                        'sort' => 55,
                    ],
                    [
                        'name' => '工場・製造',
                        'sort' => 60,
                    ],
                    [
                        'name' => '倉庫・軽作業',
                        'sort' => 65,
                    ],
                    [
                        'name' => '物流・配送',
                        'sort' => 70,
                    ],
                    [
                        'name' => '建築・土木',
                        'sort' => 75,
                    ],
                    [
                        'name' => 'その他',
                        'sort' => 80,
                    ]
                ],
            ],
            [
                'name' => 'エリア',
                'slug' => 'area',
                'children' => [
                    [
                        'name' => '未登録',
                        'slug' => 'unregistered',
                        'sort' => 0,

                    ],
                    [
                        'name' => '大楽毛・星が浦・鶴野・中鶴野・新野',
                        'sort' => 5,
                    ],
                    [
                        'name' => '鳥取',
                        'sort' => 10,
                    ],
                    [
                        'name' => '西港・新富士町',
                        'sort' => 15,
                    ],
                    [
                        'name' => '昭和・北園',
                        'sort' => 20,
                    ],
                    [
                        'name' => '文苑・愛国・芦野・美原',
                        'sort' => 25,
                    ],
                    [
                        'name' => '新橋大通り周辺',
                        'sort' => 30,
                    ],
                    [
                        'name' => '柳町公園付近',
                        'sort' => 35,
                    ],
                    [
                        'name' => '川北町・入江町・新釧路町・旭町・川上町',
                        'sort' => 40,
                    ],
                    [
                        'name' => '釧路駅裏',
                        'sort' => 45,
                    ],
                    [
                        'name' => '新橋大通り周辺',
                        'sort' => 50,
                    ],
                    [
                        'name' => 'イオン釧路店周辺',
                        'sort' => 55,
                    ],
                    [
                        'name' => '貝塚・緑ヶ岡・材木町',
                        'sort' => 60,
                    ],
                    [
                        'name' => '武佐',
                        'sort' => 65,
                    ],
                    [
                        'name' => '城山・住吉・鶴ヶ岱・大川町',
                        'sort' => 70,
                    ],
                    [
                        'name' => '桜ヶ岡・興津・益浦・白樺台',
                        'sort' => 75,
                    ],
                    [
                        'name' => '春採・紫雲台・春湖台・千代ノ浦',
                        'sort' => 80,
                    ],
                    [
                        'name' => '幣舞町・富士見・千歳町・柏木町',
                        'sort' => 85,
                    ],
                    [
                        'name' => '南大通周辺',
                        'sort' => 90,
                    ],
                    [
                        'name' => '釧路ガス周辺',
                        'sort' => 95,
                    ],
                    [
                        'name' => '市役所周辺',
                        'sort' => 100,
                    ],
                    [
                        'name' => 'ナイトスポット',
                        'sort' => 105,
                    ],
                    [
                        'name' => '遠矢・別保方面',
                        'sort' => 110,
                    ],
                ],
            ],
            [
                'name' => '給与',
                'slug' => 'salary',
                'children' => [
                    [
                        'name' => '時給',
                        'slug' => 'salary_h',
                        'children' => [
                            [
                                'name' => '未登録',
                                'slug' => 'unregistered',
                                'sort' => 0,

                            ],
                            [
                                'name' => '700円以上',
                                'sort' => 5,
                            ],
                            [
                                'name' => '750円以上',
                                'sort' => 10,
                            ],
                            [
                                'name' => '800円以上',
                                'sort' => 15,
                            ],
                            [
                                'name' => '850円以上',
                                'sort' => 20,
                            ],
                            [
                                'name' => '900円以上',
                                'sort' => 25,
                            ],
                            [
                                'name' => '950円以上',
                                'sort' => 30,
                            ],
                            [
                                'name' => '1,000円以上',
                                'sort' => 35,
                            ],
                            [
                                'name' => '1,050円以上',
                                'sort' => 40,
                            ],
                            [
                                'name' => '1,100円以上',
                                'sort' => 45,
                            ],
                            [
                                'name' => '1,200円以上',
                                'sort' => 50,
                            ],
                            [
                                'name' => '1,300円以上',
                                'sort' => 55,
                            ],
                            [
                                'name' => '1,500円以上',
                                'sort' => 60,
                            ]
                        ],
                    ],
                    [
                        'name' => '日給',
                        'slug' => 'salary_d',
                        'children' => [
                            [
                                'name' => '未登録',
                                'slug' => 'unregistered',
                                'sort' => 0,

                            ],
                            [
                                'name' => '6,500円未満',
                                'sort' => 5,
                            ],
                            [
                                'name' => '6,500円以上',
                                'sort' => 10,
                            ],
                            [
                                'name' => '7,000円以上',
                                'sort' => 15,
                            ],
                            [
                                'name' => '8,000円以上',
                                'sort' => 20,
                            ],
                            [
                                'name' => '9,000円以上',
                                'sort' => 25,
                            ],
                            [
                                'name' => '10,000円以上',
                                'sort' => 30,
                            ],
                            [
                                'name' => '12,000円以上',
                                'sort' => 35,
                            ],
                            [
                                'name' => '15,000円以上',
                                'sort' => 40,
                            ],
                        ],
                    ],
                    [
                        'name' => '月給',
                        'slug' => 'salary_m',
                        'children' => [
                            [
                                'name' => '未登録',
                                'slug' => 'unregistered',
                                'sort' => 0,

                            ],
                            [
                                'name' => '15万円未満',
                                'sort' => 5,
                            ],
                            [
                                'name' => '15万円以上',
                                'sort' => 10,
                            ],
                            [
                                'name' => '18万円以上',
                                'sort' => 15,
                            ],
                            [
                                'name' => '20万円以上',
                                'sort' => 20,
                            ],
                            [
                                'name' => '21万円以上',
                                'sort' => 25,
                            ],
                            [
                                'name' => '22万円以上',
                                'sort' => 30,
                            ],
                            [
                                'name' => '23万円以上',
                                'sort' => 35,
                            ],
                            [
                                'name' => '24万円以上',
                                'sort' => 40,
                            ],
                            [
                                'name' => '25万円以上',
                                'sort' => 45,
                            ],
                            [
                                'name' => '26万円以上',
                                'sort' => 50,
                            ],
                            [
                                'name' => '27万円以上',
                                'sort' => 55,
                            ],
                            [
                                'name' => '28万円以上',
                                'sort' => 60,
                            ],
                            [
                                'name' => '30万円以上',
                                'sort' => 65,
                            ]
                        ],
                    ],
                ],
            ],
            [
                'name' => '勤務日数',
                'slug' => 'date',
                'children' => [
                    [
                        'name' => '未登録',
                        'slug' => 'unregistered',
                        'sort' => 0,

                    ],
                    [
                        'name' => '週1日以上',
                        'sort' => 5,
                    ],
                    [
                        'name' => '週2日以上',
                        'sort' => 10,
                    ],
                    [
                        'name' => '週3日以上',
                        'sort' => 15,
                    ],
                    [
                        'name' => '週4日以上',
                        'sort' => 20,
                    ],
                    [
                        'name' => '週5日以上',
                        'sort' => 25,
                    ],
                    [
                        'name' => '週6日以上',
                        'sort' => 30,
                    ]
                ],
            ],
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
