<p>求人サイト JOBCiNEMA</p>
<br>

<p>{{$jobAppData['last_name']}} {{$jobAppData['first_name']}} 様</p>
<br>

<p>企業から電話で連絡がありますのでご注意ください。</p>
<br>

<p>■応募先情報</p>
<p>【企業名】：{{$company['cname']}}</p>
<p>【勤務先名】：{{$jobId['job_office']}}</p>
<p>【担 当 名】：{{$employer['last_name']}}</p>
<p>【電話番号】：{{$employer['phone1']}}-{{$employer['phone2']}}-{{$employer['phone3']}}</p>
<br>

<p>※応募企業の情報はMyページからも確認できます</p>
<a href="{{route('mypages.index')}}">{{route('mypages.index')}}</a>
<br>

@if($jobId['festive_money'])
<p>■採用お祝い金プレゼント</p>
<p>採用された方には、JOBCiNEMAより採用お祝い金をプレゼントします！</p>
<br>
<p>★こんな場合も対象になります</p>
<p>・辞退・不採用の連絡後改めて採用された場合</p>
<p>・応募した企業から別のお仕事（会社）を紹介された場合</p>
<p>・応募した職種・勤務地以外に採用された場合</p>
<p>※初出社には研修期間（試用期間）も含みます。</p>
<p><※採用お祝い金は、JOBCiNEMAよりプレゼントします。/p>
<p>採用企業様より直接お渡しすることはありません。</p>
<p>※退会した場合はお祝い金はもらえません。</p>
<br>
@endif

<p>＜ 運営情報 ＞</p>
<p>JOBCiNEMA</p>
<p>お問い合わせ：customer@jobcinema.com</p>
<a href="https://job-cinema.com/">https://job-cinema.com/</a>

