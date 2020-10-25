<p>求人サイト JOBCiNEMA</p>
<br>
<p>{{$employer['last_name']}} {{$employer['first_name']}} 様</p>
<br>
<p>応募者に電話で連絡をしてください。</p>
<br>
<p>■応募があった求人</p>
<p>【求人番号】：{{$jobitem['id']}}</p>
<p>【企業】：{{$company['cname']}}</p>
<p>【勤務先】：{{$jobitem['job_office']}}</p>
<p>【職種】：{{$jobitem['job_type']}}</p>
<p>【住所】：{{$jobitem['job_office_address']}}</p>
<p>【求人票】： <a href="{{route('show.front.job_sheet.detail', ['jobitem' => $jobitem])}}">{{route('show.front.job_sheet.detail', ['jobitem' => $jobitem])}}</a></p>
<br>
<p>■応募者</p>
<p>【名前】：{{$data['last_name']}} {{$data['first_name']}}</p>
<p>【メールアドレス】：{{$data['email']}}</p>
<p>【電話番号】：{{$data['phone1']}}-{{$data['phone2']}}-{{$data['phone3']}}</p>
<p>【職業】：{{$data['occupation']}}</p>
<p>【性別】：{{$data['gender']}}</p>
<p>【年齢】：{{$data['age']}}</p>
<br>
<p>※応募者の詳細情報は企業マイページからも確認できます</p>
<a href="{{route('index.company.mypage')}}">{{route('index.company.mypage')}}</a>
<br>
<br>
@if($jobitem->existsCongratsMoney())
<p>■採用お祝い金対象の求人です</p>
<p>応募者が採用された場合、JOBCiNEMAより応募者に採用お祝い金をプレゼントします</p>
<br>
<p>※採用企業様より応募者に直接お渡しすることはありません</p>
<p>採用お祝い金は、JOBCiNEMAが行います</p>
<br>
@endif

<p>＜ 運営情報 ＞</p>
<p>JOBCiNEMA</p>
<p>お問い合わせ：{{config('mail.contact.address')}}</p>
<a href="{{url('/')}}">{{url('/')}}</a>
