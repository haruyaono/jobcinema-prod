<p>求人サイト JOBCiNEMA</p>
<br>

<p>{{$employer['last_name']}} {{$employer['first_name']}} 様</p>
<br>

<p>応募者に電話で連絡をしてください。</p>
<br>

<p>■応募された求人</p>
<p>【求人番号】：{{$jobId['id']}}</p>
<p>【企業】：{{$company['cname']}}</p>
<p>【勤務先】：{{$jobId['job_office']}}</p>
<p>【職種】：{{$jobId['job_type']}}</p>
<p>【住所】：{{$jobId['job_office_address']}}</p>
<p>【求人ページ】： <a href="{{route('jobs.show', ['id' => $jobId->id, 'job' => $jobId->slug])}}">{{route('jobs.show', ['id' => $jobId->id, 'job' => $jobId->slug])}}</a></p>
<br>

<p>■応募者</p>
<p>【名前】：{{$jobAppData['last_name']}} {{$jobAppData['first_name']}}</p>
<p>【メールアドレス】：{{$jobAppData['email']}}</p>
<p>【電話番号】：{{$jobAppData['phone1']}}-{{$jobAppData['phone2']}}-{{$jobAppData['phone3']}}</p>
<p>【職業】：{{$jobAppData['occupation']}}</p>
<p>【性別】：{{$jobAppData['gender']}}</p>
<p>【年齢】：{{$jobAppData['age']}}</p>
<br>

<p>※応募者の詳細情報は企業マイページからも確認できます</p>
<a href="{{route('company.mypage')}}">{{route('company.mypage')}}</a>
<br>

@if($jobId['festive_money'])
    <p>■採用お祝い金対象の求人です</p>
    <p>応募者が採用された場合、JOBCiNEMAより応募者に採用お祝い金をプレゼントします</p>
    <br>
    <p>※採用企業様より応募者に直接お渡しすることはありません。す</p>
    <p>採用お祝い金は、JOBCiNEMAが行います。</p>
    <br>
@endif

<p>＜ 運営情報 ＞</p>
<p>JOBCiNEMA</p>
<p>お問い合わせ：customer@jobcinema.com</p>
<a href="https://job-cinema.com/">https://job-cinema.com/</a>

