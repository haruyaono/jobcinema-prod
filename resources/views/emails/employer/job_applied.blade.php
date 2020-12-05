<p>求人サイト JOBCiNEMA</p>
<p>{{ $employer['last_name'] }} {{ $employer['first_name'] }} 様</p>
<p>応募がありました。<br>応募者に電話もしくはメールで連絡をして下さい。</p>
<p>■応募があった求人<br>
    【求人番号】 {{ $jobitem['id'] }}<br>
    【勤務先名】 {{ $jobitem['job_office'] }}<br>
    【職種】 {{ $jobitem['job_type'] }}<br>
    【住所】 {{ $jobitem['job_office_address'] }}<br>
    【求人票】 <a href="{{ route('show.front.job_sheet.detail', [$jobitem]) }}">{{ route('show.front.job_sheet.detail', [$jobitem]) }}</a>
</p>
<p>■応募者情報<br>
    【名前】 {{ $data['last_name'] }} {{ $data['first_name'] }}<br>
    【メールアドレス】 {{ $data['email'] }}<br>
    【電話番号】 {{ $data['phone1'] }}-{{ $data['phone2'] }}-{{ $data['phone3'] }}<br>
    【職業】 {{ $data['occupation'] }}<br>
    【性別】 {{ $data['gender'] }}<br>
    【年齢】 {{ $data['age'] }}<br>
</p>
<p>※応募者の詳細情報は管理画面から確認できます<br>
    <a href="{{ route('enterprise.index.mypage') }}">{{ route('enterprise.index.mypage') }}</a>
</p>
<p>＜ 運営情報 ＞<br>
    JOBCiNEMA<br>
    お問い合わせ : {{ config('mail.contact.address') }}<br>
    サイトURL : <a href="{{ url('/') }}">{{ url('/') }}</a>
</p>
