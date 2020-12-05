<p>求人サイト JOBCiNEMA</p>
<br>

<p>{{$employer['last_name']}} {{$employer['first_name']}} 様</p>
<br>

<p>申請された求人票が承認されました。</p>
<br>

<p>■承認された求人票</p>
<p>【求人番号】：{{$job['id']}}</p>
<p>【企業】：{{$job->company['cname']}}</p>
<p>【勤務先】：{{$job['job_office']}}</p>
<p>【職種】：{{$job['job_type']}}</p>
<p>【住所】：{{$job['job_office_address']}}</p>
<br>

<p>※求人票の公開停止・編集は企業マイページから操作できます。</p>
<a href="{{ route('enterprise.index.mypage') }}">{{ route('enterprise.index.mypage') }}</a>
<br>

<p>＜ 運営情報 ＞</p>
<p>JOBCiNEMA</p>
<p>お問い合わせ：{{ config('mail.contact.address') }}</p>
<a href="{{ url('/') }}">{{ url('/') }}</a>
