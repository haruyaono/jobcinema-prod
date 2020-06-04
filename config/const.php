<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Const
    |--------------------------------------------------------------------------
    */

    // 0:仮登録 1:本登録 2:メール認証済 8:退会申請中 9:退会済
    'EMPLOYER_STATUS' => ['PRE_REGISTER' => '0', 'REGISTER' => '1', 'MAIL_AUTHED' => '2', 'PRE_DEACTIVE' => '8', 'DEACTIVE' => '9',],

    // 0:選考中 1:採用 2:不採用
    'JOB_STATUS' => ['0' => '選考中', '1' => '採用', '2' => '不採用'],

     // 0:一時保存中 1:承認待ち 2:掲載中 3:非承認 4:公開停止 5:削除申請中 6:完全非公開
     'EMP_JOB_STATUS' => ['0' => '一時保存中', '1' => '承認待ち', '2' => '掲載中', '3' => '非承認', '4' => '公開停止中', '5' => '削除申請中', '6' => '完全非公開'],


    'OIWAIKIN' => ['null' => 'なし', '2000' => '対象'],

    // 0:審査中 1:確定 2:送付済み  3:キャンセル
    'OIWAIKIN_STATUS' => ['0' => '未申請', '1' => '審査中', '2' => '確定', '3' => '送付済み', '4' => 'キャンセル'],

    'INDUSTORIES' => [
        'IT・通信','インターネット・広告・メディア','メーカー（機械・電気','メーカー（素材・化学・食品・化粧品・その他）',
        '商社','医薬品・医療機器・ライフサイエンス・医療系サービス','金融','建設・プラント・不動産',
        'コンサルティング・専門事務所・監査法人・税理士法人・リサーチ','人材サービス・アウトソーシング・コールセンター','小売','外食',
        '運輸・物流','エネルギー（電力・ガス・石油・新エネルギー）','旅行・宿泊・レジャー','警備・清掃','理容・美容・エステ',
        '教育', '農林水産・鉱業', '公社・官公庁・学校・研究施設', '公社・官公庁・学校・研究施設', 'その他', 
    ],

    'EMPLOYEE_NUMBERS' => [
        '1〜10人','11〜50人','51〜100人','101〜300人','301〜500人','501〜1000人','1001〜5000人','5001〜10000人','10001以上',
    ],

];