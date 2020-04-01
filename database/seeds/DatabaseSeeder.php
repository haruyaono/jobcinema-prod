<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\StatusCat;
use App\Models\TypeCat;
use App\Models\AreaCat;
use App\Models\HourlySalaryCat; 
use App\Models\DateCat;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->truncate();
        // DB::table('admins')->truncate();
        // DB::table('employers')->truncate();
        // DB::table('companies')->truncate();
        // DB::table('job_items')->truncate();
        DB::table('status_cats')->truncate();
        DB::table('type_cats')->truncate();
        DB::table('area_cats')->truncate();
        DB::table('hourly_salary_cats')->truncate();
        DB::table('date_cats')->truncate();
        DB::table('profiles')->truncate();
        DB::table('job_item_user')->truncate();
        DB::table('favourites')->truncate();
        

        // factory('App\Models\User', 20)->create();
        // factory('App\Models\Admin', 1)->create();
        // factory('App\Models\Employer', 20)->create();
        // factory('App\Models\Company', 20)->create();
        // factory('App\Models\JobItem', 20)->create();

        $statusCats = [
            '正社員',
            'パート・アルバイト',
            '契約社員',
            '業務委託・完全歩合制',
        ];
        foreach($statusCats as $statusCat) {
            StatusCat::create(['name' => $statusCat]);
        }
        $typeCats = [
            '事務・オフィス',
            '飲食・フード',
            '販売・接客・サービス',
            'アパレル・ファッション',
            '美容・エステ',
            'エンタメ・アミューズメント',
            '営業',
            'Web・クリエイティブ',
            'IT・エンジニア',
            '教育',
            '医療・介護・保育',
            '工場・製造',
            '倉庫・軽作業',
            '物流・配送',
            '建築・土木',
            'その他',
        ];
        foreach($typeCats as $typeCat) {
            TypeCat::create(['name' => $typeCat]);
        }

        $areaCats = [
            '昭和・鳥取・新富士',
            '星が浦・鶴野',
            '大楽毛',
            '阿寒・白糠',
            '釧路駅前',
            '釧路駅裏',
            '愛国',
            '釧路町',
            '芦野',
            '文苑・美原',
            '釧路春採・桜ヶ岡・興津',
            '緑ヶ岡・貝塚・武佐',
            '米町～鶴ヶ岱',
            '中標津・標茶・厚岸',
        ];
        foreach($areaCats as $areaCat) {
            AreaCat::create(['name' => $areaCat]);
        }


        $hourlySalaryCats = [
            '800円以上',
            '850円以上',
            '900円以上',
            '950円以上',
            '1000円以上',
            '1050円以上',
            '1100円以上',
            '1200円以上',
            '1300円以上',
            '1400円以上',
            '1500円以上',
        ];
        foreach($hourlySalaryCats as $hourlySalaryCat) {
            HourlySalaryCat::create(['name' => $hourlySalaryCat]);
        }

        $dateCats = [
            '週１日〜',
            '週２日〜',
            '週３日〜',
            '週４日〜',
            '週５日〜',
            '週６日〜',
        ];
        foreach($dateCats as $dateCat) {
            DateCat::create(['name' => $dateCat]);
        }
    }
}
