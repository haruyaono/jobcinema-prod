<p>求人サイト JOBCiNEMA</p>
<br>

<p>{{$employer['last_name']}} {{$employer['first_name']}} 様</p>
<br>

<p>以下の求人票が完全非公開になりました。</p>
<p>内容を変更し再度申請することも可能です。</p>
<br>

<p>■非公開になった求人票</p>
<p>【求人番号】：{{$job['id']}}</p>
<p>【企業】：{{$job->company['cname']}}</p>
<p>【勤務先】：{{$job['job_office']}}</p>
<p>【職種】：{{$job['job_type']}}</p>
<p>【住所】：{{$job['job_office_address']}}</p>
<br>

<p>※求人票の閲覧・編集は企業マイページからも確認できます</p>
<a href="{{route('company.mypage')}}">{{route('company.mypage')}}</a>
<br>

<p>＜ 運営情報 ＞</p>
<p>JOBCiNEMA</p>
<p>お問い合わせ：customer@jobcinema.com</p>
<a href="{{url('/')}}">{{url('/')}}</a>

