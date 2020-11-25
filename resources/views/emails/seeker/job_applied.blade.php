<p>求人サイト JOBCiNEMA</p>
<p>{{ $data['last_name'] }} {{ $data['first_name'] }} 様</p>
<p>ご応募が完了しました。<br>企業から電話で連絡がありますのでご注意ください。</p>
<p>■応募企業情報
    【企業名】 {{ $company['cname'] }}<br>
    【勤務先名】 {{ $jobitem['job_office'] }}<br>
    【担 当 名】 {{ $employer['last_name'] }}<br>
    【電話番号】 {{ $company['phone1'] }}-{{ $company['phone2'] }}-{{ $company['phone3'] }}
</p>
<p>※応募企業の情報はMyページからも確認できます<br>
    <a href="{{ route('seeker.index.mypage') }}">{{ route('seeker.index.mypage') }}</a>
</p>
<p>
    ■まずは応募先からの連絡をお待ちください。<br>
    <br>
    電話、メールで連絡があります。<br>
    ・採用結果が分かりましたら、マイページ応募管理より採用報告をして下さい。<br>
    ・知らない番号からの電話にも出て下さい。<br>
    ・留守電をONにして下さい。<br>
    ・迷惑メールボックスも確認して下さい。<br>
    ※数日たっても応募先から連絡が無い場合は、電話で応募先に問い合わせて下さい。
</p>
<p>＜ 運営情報 ＞<br>
    JOBCiNEMA<br>
    お問い合わせ : {{ config('mail.contact.address') }}<br>
    サイトURL : <a href="{{ url('/') }}">{{ url('/') }}</a>
</p>
