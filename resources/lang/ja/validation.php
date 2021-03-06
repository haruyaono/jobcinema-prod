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
    'after_or_equal'       => ':attributeは:date以降の日付にしてください。',
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
    'not_in'               => ':attributeを選択してください。',
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
        // 共通
        'amount' => '金額',
        'label' => 'ラベル',
        // 求職者
        'email' => '「メールアドレス」',
        'password' => '「パスワード」',
        'current-password' => '「現在のパスワード」',
        'new-password' => '「新しいパスワード」',
        // 求職者プロフィール
        'data.user.last_name' => '「お名前（カナ）」',
        'data.user.first_name' => '「お名前（カナ）」',
        'data.profile.phone1' => '「電話番号1」',
        'data.profile.phone2' => '「電話番号2」',
        'data.profile.phone3' => '「電話番号3」',
        'data.profile.gender' => '「性別」',
        'data.profile.age' => '「年齢」',
        'data.profile.postcode01' => '「郵便番号1」',
        'data.profile.postcode02' => '「郵便番号2」',
        'data.profile.prefecture' => '「都道府県」',
        'data.profile.city' => '「住所」',
        'data.profile.work_start_date' => '勤務開始可能日',
        'data.profile.occupation' => '現在の職業',
        'data.profile.final_education' => '最終学歴',
        //　応募
        'data.apply.last_name' => '「お名前（カナ）」',
        'data.apply.first_name' => '「お名前（カナ）」',
        'data.apply.phone1' => '「電話番号1」',
        'data.apply.phone2' => '「電話番号2」',
        'data.apply.phone3' => '「電話番号3」',
        'data.apply.gender' => '「性別」',
        'data.apply.age' => '「年齢」',
        'data.apply.postcode01' => '「郵便番号1」',
        'data.apply.postcode02' => '「郵便番号2」',
        'data.apply.prefecture' => '「都道府県」',
        'data.apply.city' => '「住所」',
        'data.apply.work_start_date' => '勤務開始可能日',
        'data.apply.occupation' => '現在の職業',
        'data.apply.final_education' => '最終学歴',
        'data.apply.job_msg' => '志望動機・メッセージ',
        // 応募管理
        'data.apply.year' => '年',
        'data.apply.month' => '月',
        'data.apply.date' => '日',
        'full_date' => '初出社日',
        'data.apply.s_nofirst_attendance' => '初出社日未定',
        'data.apply.e_nofirst_attendance' => '初出社日未定',
        'data.is_attendance' => '初出社日のチェック',
        // 採用担当者
        'e_last_name' => '「ご担当者様名」',
        'e_first_name' => '「ご担当者様名」',
        'e_last_name_katakana' => '「ご担当者様名（フリガナ）」',
        'e_first_name_katakana' => '「ご担当者様名（フリガナ）」',
        'e_phone1' => '「ご担当者様電話番号」',
        'e_phone2' => '「ご担当者様電話番号」',
        'e_phone3' => '「ご担当者様電話番号」',
        // 求人票
        'data.JobSheet.categories.status.id' => '雇用形態',
        'data.JobSheet.categories.type.id' => '募集職種',
        'data.JobSheet.categories.area.id' => '勤務地エリア',
        'data.JobSheet.categories.salary' => '最低給与',
        'data.JobSheet.categories.date.id' => '最低勤務日数',
        'data.JobSheet.categories.salary.2.parent_slug' => '無効な値です',
        'data.JobSheet.categories.date.id' => '最低勤務日数',
        'data.JobSheet.job_title' => 'キャッチコピー',
        'data.JobSheet.job_intro' => '紹介文',
        'data.JobSheet.job_office' => '勤務先名',
        'data.JobSheet.job_office_address' => '住所',
        'data.JobSheet.job_type' => '職種',
        'data.JobSheet.job_desc' => '仕事内容',
        'data.JobSheet.job_salary' => '給与',
        'data.JobSheet.salary_increase' => '昇給・賞与',
        'data.JobSheet.job_target' => '応募資格',
        'data.JobSheet.job_time' => '勤務時間',
        'data.JobSheet.job_treatment' => '待遇・福利厚生',
        'data.JobSheet.pub_start_flag' => '掲載開始日フラグ',
        'data.JobSheet.pub_end_flag' => '掲載終了日フラグ',
        'data.JobSheet.pub_start_date' => '掲載開始日',
        'data.JobSheet.pub_end_date' => '掲載終了日',
        'data.JobSheet.remarks' => '備考',
        'data.File.image' => '写真',
        'data.File.movie' => '動画',
        // お問い合わせ
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
        // 管理者
        'name' => 'ユーザー名',
    ],
];
