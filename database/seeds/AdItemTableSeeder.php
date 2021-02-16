<?php

use Illuminate\Database\Seeder;
use App\Models\AdItem;

class AdItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdItem::create([
            'company_id' => 1,
            'job_item_id' => 1,
            'image_path' => '/img/common/realidea.png',
            'description' => 'ExampleImg',
            'price' => 100000,
            'is_view' => false,
            'started_at' => date("Y-m-d H:i:s", 1612105200),
            'ended_at' => date("Y-m-d H:i:s", 1614524399),
        ]);
    }
}
