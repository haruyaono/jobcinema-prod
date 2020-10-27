<?php

use Illuminate\Database\Seeder;
use App\Job\AchievementRewards\AchievementReward;

class AchievementRewardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list =  [
            [
                'amount' => 30000,
                'label' => 'なし',
                'category_id' => 3
            ],
            [
                'amount' => 50000,
                'label' => 'なし',
                'category_id' => 4
            ],
            [
                'amount' => 150000,
                'label' => 'なし',
                'category_id' => 5
            ],
            [
                'amount' => 200000,
                'label' => 'なし',
                'category_id' => 6
            ],

        ];

        foreach ($list as $item) {
            AchievementReward::create($item);
        }
    }
}
