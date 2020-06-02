<?php  // resources/lang/ja/validation.php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'active_url'           => ':attributeは正しいURLではありません。',
    'after'                => ':attributeは:date以降の日付にしてください。',
    'alpha'                => ':attributeは英字のみにしてください。',
    'alpha_dash'           => ':attributeは英数字とハイフンのみにしてください。',
    'alpha_num'            => ':attributeは英数字のみにしてください。',
    'array'                => ':attributeは配列にしてください。',
    'before'               => ':attributeは:date以前の日付にしてください。',
    'between'              => [
        'numeric' => ':attributeは:min〜:maxまでにしてください。',
        'file'    => ':attributeは:min〜:max KBまでのファイルにしてください。',
        'string'  => ':attributeは:min〜:max文字にしてください。',
        'array'   => ':attributeは:min〜:max個までにしてください。',
    ],
    'boolean'              => ':attributeはtrueかfalseにしてください。',
    'confirmed'            => ':attributeは確認用項目と一致していません。',
    'date'                 => ':attributeは正しい日付ではありません。',
    'date_format'          => ':attributeは":format"書式と一致していません。',
    'different'            => ':attributeは:otherと違うものにしてください。',
    'digits'               => ':attributeは:digits桁にしてください',
    'digits_between'       => ':attributeは:min〜:max桁にしてください。',
    'email'                => '「メールアドレス」が正しくありません。',
    'filled'               => ':attributeは必須です。',
    'exists'               => '選択された:attributeは正しくありません。',
    'image'                => ':attributeは画像にしてください。',
    'in'                   => '選択された:attributeは正しくありません。',
    'integer'              => ':attributeは整数にしてください。',
    'ip'                   => ':attributeを正しいIPアドレスにしてください。',
    'max'                  => [
        'numeric' => ':attributeは:max以下にしてください。',
        'file'    => ':attributeは:max KB以下のファイルにしてください。.',
        'string'  => ':attributeは:max文字以下にしてください。',
        'array'   => ':attributeは:max個以下にしてください。',
    ],
    'mimes'                => ':attributeは:valuesタイプのファイルにしてください。',
    'min'                  => [
        'numeric' => ':attributeは:min以上にしてください。',
        'file'    => ':attributeは:min KB以上のファイルにしてください。.',
        'string'  => ':attributeは:min文字以上にしてください。',
        'array'   => ':attributeは:min個以上にしてください。',
    ],
    'not_in'               => '選択してください。',
    'numeric'              => ':attributeは数字にしてください。',
    'regex'                => ':attributeの書式が正しくありません。',
    'required'             => ':attributeは必須項目です。',
    'required_if'          => ':otherが:valueの時、:attributeは必須です。',
    'required_with'        => ':valuesが存在する時、:attributeは必須です。',
    'required_with_all'    => ':valuesが存在する時、:attributeは必須です。',
    'required_without'     => ':valuesが存在しない時、:attributeは必須です。',
    'required_without_all' => ':valuesが存在しない時、:attributeは必須です。',
    'same'                 => ':attributeと:otherは一致していません。',
    'size'                 => [
        'numeric' => ':attributeは:sizeにしてください。',
        'file'    => ':attributeは:size KBにしてください。.',
        'string'  => ':attribute:size文字にしてください。',
        'array'   => ':attributeは:size個にしてください。',
    ],
    'string'               => ':attributeは文字列にしてください。',
    'timezone'             => ':attributeは正しいタイムゾーンをしていしてください。',
    'unique'               => ':attributeは既に存在します。',
    'url'                  => ':attributeを正しい書式にしてください。',

    'kana'                 => ':attributeは平仮名もしくはカタカナで入力して下さい。',
    'katakana'             => ':attributeはカタカナで入力して下さい。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        //user
        'email' => '「メールアドレス」',
        'password' => '「パスワード」',
        'current-password' => '「現在のパスワード」',
        'new-password' => '「新しいパスワード」',
        //user profile
        'last_name' => '「お名前（カナ）」',
        'first_name' => '「お名前（カナ）」',
        'phone1' => '「電話番号」',
        'phone2' => '「電話番号」',
        'phone3' => '「電話番号」',
        'gender' => '「性別」',
        'age' => '「年齢」',
        'resume' => '「履歴書ファイル」',
        'work_start_date' => '勤務開始可能日',
        'occupation' => '現在の職業',
        'final_education' => '最終学歴',
        'job_msg' => '志望動機・メッセージ',

        //employer
        'e_last_name' => '「ご担当者様名」',
        'e_first_name' => '「ご担当者様名」',
        'e_last_name_katakana' => '「ご担当者様名（フリガナ）」',
        'e_first_name_katakana' => '「ご担当者様名（フリガナ）」',
        'e_phone1' => '「ご担当者様電話番号」',
        'e_phone2' => '「ご担当者様電話番号」',
        'e_phone3' => '「ご担当者様電話番号」',
        //company
        'cname' => '「会社名」',
        'cname_katakana' => '「会社名（フリガナ）」',
        'zip31' => '「郵便番号」',
        'zip32' => '「郵便番号」',
        'pref31' => '「都道府県」',
        'addr31' => '「住所」',
        'ceo' => '「代表者様」',
        'f_year' => '「設立」',
        'f_month' => '「設立」',
        'capital' => '「資本金」',
        'industry' => '「業種」',
        'description' => '「事業内容」',
        'employee_number' => '「従業員数」',
        'website' => '「ホームページ」',
        'c_phone1' => '「応募者に通知する電話番号」',
        'c_phone2' => '「応募者に通知する電話番号」',
        'c_phone3' => '「応募者に通知する電話番号」',
        'logo' => '「企業ロゴ」',
        
        // 求人票
        'job_title' => 'キャッチコピー',
        'job_intro' => '紹介文',
        'job_office' => '勤務先名',
        'job_office_address' => '住所',
        'job_type' => '職種',
        'job_desc' => '仕事内容',
        'job_hourly_salary' => '給与',
        'salary_increase' => '昇給・賞与',
        'job_target' => '応募資格',
        'job_time' => '勤務時間',
        'job_treatment' => '待遇・福利厚生',
        'pub_start' => '掲載開始日',
        'pub_end' => '掲載終了日',
        'remarks' => '備考',
        'status_cat_id' => '雇用形態',
        'type_cat_id' => '募集職種',
        'area_cat_id' => '勤務地エリア',
        'hourly_salary_cat_id' => '最低時給',
        'date_cat_id' => '最低勤務日数',
        'job_main_img' => 'メイン写真',
        'job_sub_img' => 'サブ写真',
        'job_sub_img2' => 'サブ写真',
        'job_main_mov' => 'メイン動画',
        'job_sub_mov' => 'サブ動画',
        'job_sub_mov2' => 'サブ動画',

        //contact
        'name' => '氏名',
        'name_ruby' => '氏名(フリガナ)',
        'e_name' => '担当者名',
        'e_name_ruby' => '担当者名(フリガナ)',
        'phone' => '電話番号',
        'content' => '内容',
        'e_name' => '「ご担当者様名」',

        // その他
        'year' => '西暦',
        'month' => '月',
        'date' => '日付',
        'app_oiwai_text' => '状況',

        //admin
        'name' => 'ユーザー名',
    ],
];
