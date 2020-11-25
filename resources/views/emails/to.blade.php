@if($content['c_flag'] == 'seeker')

<p>
    {{$content['name']}} 様
</p>
<p>
    ……………………………………………………………………………<br>
    　以下の内容でお問い合わせを受付いたしました。<br>
    　お問い合わせ内容に関するご返答は3営業日以内に行います。<br>
    ……………………………………………………………………………<br>
</p>
<p>
    【お問い合わせカテゴリ】<br>
    {{$content['category']}}
</p>
<p>
    【氏名】<br>
    {{$content['name']}}
</p>
<p>
    【氏名(フリガナ)】<br>
    {{$content['name_ruby']}}
</p>
<p>
    【返信先メールアドレス】<br>
    {{$content['email']}}
</p>
<p>
    【連絡先電話番号】<br>
    {{$content['phone']}}
</p>
<p>
    【お問い合わせ内容】<br>
    {{$content['content']}}
</p>

@elseif($content['c_flag'] == 'employer')
<p>
    {{$content['name']}} 様
</p>
<p>
    ……………………………………………………………………………<br>
    　以下の内容でお問い合わせを受付いたしました。<br>
    　お問い合わせ内容に関するご返答は3営業日以内に行います。<br>
    ……………………………………………………………………………<br>
</p>
<p>
    【お問い合わせカテゴリ】<br>
    {{$content['category']}}
</p>
<p>
    【企業名】<br>
    {{$content['cname']}}
</p>
<p>
    【企業名(フリガナ)】<br>
    {{$content['cname_katakana']}}
</p>
<p>
    【担当者名】<br>
    {{$content['name']}}
</p>
<p>
    【担当者名(フリガナ)】<br>
    {{$content['name_ruby']}}
</p>
<p>
    【返信先メールアドレス】<br>
    {{$content['email']}}
</p>
<p>
    【連絡先電話番号】<br>
    {{$content['phone']}}
</p>
<p>
    【お問い合わせ内容】<br>
    {{$content['content']}}
</p>
@endif
<p>─────────────────────────────────</p>
<p>
    お問い合わせ内容に関するご返答は3営業日以内に行います。<br>
    万が一返信が来なかった場合、メール不達の可能性があります。<br>
    お手数ですが、釧路なび　JOB CiNEMA事業部<masaya.takeda@kushiro-navi.com>までお問い合わせ下さい。<br>
        尚、新規お取引のご案内に関しましては、当事業部にて判断の上、必要な場合のみご連絡させて頂きます。<br>
</p>
<p>-------------------------------------------------</p>
<p>＜ 運営情報 ＞<br>
    JOBCiNEMA<br>
    お問い合わせ：{{ config('mail.contact.address') }}<br>
    <a href="{{ url('/') }}">{{ url('/') }}</a></p>
<p>-------------------------------------------------</p>
