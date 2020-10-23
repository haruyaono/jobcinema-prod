<?php

use Illuminate\Database\Seeder;
use App\Job\Categories\Category;

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
                        'name' => '正社員',
                        'sort' => 5,
                    ],
                    [
                        'name' => 'パート・アルバイト',
                        'sort' => 10,
                    ],
                    [
                        'name' => '契約社員',
                        'sort' => 15,
                    ],
                    [
                        'name' => '業務委託・完全歩合制',
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
                        'name' => '昭和・鳥取・新富士',
                        'sort' => 5,
                    ],
                    [
                        'name' => '星が浦・鶴野',
                        'sort' => 10,
                    ],
                    ['name' => '大楽毛'],
                    [
                        'name' => '阿寒・白糠',
                        'sort' => 15,
                    ],
                    [
                        'name' => '釧路駅前',
                        'sort' => 20,
                    ],
                    [
                        'name' => '釧路駅裏',
                        'sort' => 25,
                    ],
                    [
                        'name' => '愛国',
                        'sort' => 30,
                    ],
                    [
                        'name' => '釧路町',
                        'sort' => 35,
                    ],
                    [
                        'name' => '芦野',
                        'sort' => 40,
                    ],
                    [
                        'name' => '文苑・美原',
                        'sort' => 45,
                    ],
                    [
                        'name' => '釧路春採・桜ヶ岡・興津',
                        'sort' => 50,
                    ],
                    [
                        'name' => '緑ヶ岡・貝塚・武佐',
                        'sort' => 55,
                    ],
                    [
                        'name' => '米町～鶴ヶ岱',
                        'sort' => 60,
                    ],
                    [
                        'name' => '中標津・標茶・厚岸',
                        'sort' => 65,
                    ]
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
