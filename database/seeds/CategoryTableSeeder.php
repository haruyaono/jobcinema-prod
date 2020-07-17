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
                        ['name' => '正社員'],
                        ['name' => 'パート・アルバイト'],
                        ['name' => '契約社員'],
                        ['name' => '業務委託・完全歩合制']
                    ],
                ],
                [
                    'name' => '職種',
                    'slug' => 'type',
                        'children' => [
                            ['name' => '事務・オフィス'],
                            ['name' => '飲食・フード'],
                            ['name' => '販売・接客・サービス'],
                            ['name' => 'アパレル・ファッション'],
                            ['name' => '美容・エステ'],
                            ['name' => 'エンタメ・アミューズメント'],
                            ['name' => '営業'],
                            ['name' => 'Web・クリエイティブ'],
                            ['name' => 'IT・エンジニア'],
                            ['name' => '教育'],
                            ['name' => '医療・介護・保育'],
                            ['name' => '工場・製造'],
                            ['name' => '倉庫・軽作業'],
                            ['name' => '物流・配送'],
                            ['name' => '建築・土木'],
                            ['name' => 'その他']
                        ],
                ],
                [
                    'name' => 'エリア',
                    'slug' => 'area',
                        'children' => [
                            ['name' => '昭和・鳥取・新富士'],
                            ['name' => '星が浦・鶴野'],
                            ['name' => '大楽毛'],
                            ['name' => '阿寒・白糠'],
                            ['name' => '釧路駅前'],
                            ['name' => '釧路駅裏'],
                            ['name' => '愛国'],
                            ['name' => '釧路町'],
                            ['name' => '芦野'],
                            ['name' => '文苑・美原'],
                            ['name' => '釧路春採・桜ヶ岡・興津'],
                            ['name' => '緑ヶ岡・貝塚・武佐'],
                            ['name' => '米町～鶴ヶ岱'],
                            ['name' => '中標津・標茶・厚岸']
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
                                            ['name' => '700円以上'],
                                            ['name' => '750円以上'],
                                            ['name' => '800円以上'],
                                            ['name' => '850円以上'],
                                            ['name' => '900円以上'],
                                            ['name' => '950円以上'],
                                            ['name' => '1,000円以上'],
                                            ['name' => '1,050円以上'],
                                            ['name' => '1,100円以上'],
                                            ['name' => '1,200円以上'],
                                            ['name' => '1,300円以上'],
                                            ['name' => '1,500円以上']
                                    ],
                            ],
                            [    
                                'name' => '日給',
                                'slug' => 'salary_d',
                                    'children' => [
                                            ['name' => '6,500円未満'],
                                            ['name' => '6,500円以上'],
                                            ['name' => '7,000円以上'],
                                            ['name' => '8,000円以上'],
                                            ['name' => '9,000円以上'],
                                            ['name' => '10,000円以上'],
                                            ['name' => '12,000円以上'],
                                            ['name' => '15,000円以上'],
                                    ],
                            ],
                            [    
                                'name' => '月給',
                                'slug' => 'salary_m',
                                    'children' => [
                                            ['name' => '15万円未満'],
                                            ['name' => '15万円以上'],
                                            ['name' => '18万円以上'],
                                            ['name' => '20万円以上'],
                                            ['name' => '21万円以上'],
                                            ['name' => '22万円以上'],
                                            ['name' => '23万円以上'],
                                            ['name' => '24万円以上'],
                                            ['name' => '25万円以上'],
                                            ['name' => '26万円以上'],
                                            ['name' => '27万円以上'],
                                            ['name' => '28万円以上'],
                                            ['name' => '30万円以上']
                                    ],
                            ],
                        ],
                ],
                [
                    'name' => '勤務日数',
                    'slug' => 'date',
                        'children' => [
                            ['name' => '週1日以上'],
                            ['name' => '週2日以上'],
                            ['name' => '週3日以上'],
                            ['name' => '週4日以上'],
                            ['name' => '週5日以上'],
                            ['name' => '週6日以上']
                        ],
                ],
        ];
        foreach($categories as $category)
        {
            Category::create($category);
        }
    }
}
