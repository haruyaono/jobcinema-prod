<?php

use Illuminate\Database\Seeder;
use App\Models\CongratsMoney;

class CongratsMoneyTableSeeder extends Seeder
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
                'amount' => 5000,
                'label' => 'なし',
                'category_id' => 3
            ],
            [
                'amount' => 10000,
                'label' => 'なし',
                'category_id' => 4
            ],
            [
                'amount' => 30000,
                'label' => 'なし',
                'category_id' => 5
            ],
            [
                'amount' => 40000,
                'label' => 'なし',
                'category_id' => 6
            ],

        ];

        foreach ($list as $item) {
            CongratsMoney::create($item);
        }
    }
}
