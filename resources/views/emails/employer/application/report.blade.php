<p>求人サイト JOBCiNEMA</p>
<p>{{ $apply->detail->full_name }} 様</p>
@if($flag != 'unadopt')
<p>この度は弊社、{{ $apply->jobitem->company->cname }} の求人にご応募いただきありがとうございました。<br>
    採用結果をお知らせいたします。</p>
@endif
@if($flag == 'adopt')
<p>審査の結果、{{ $apply->detail->full_name }}様を採用させていただくことになりました。</p>
<p>詳細な内容につきましては、後ほどお電話でお伝えいたします。</p>
<p>すでに本メールが送信済み、もしくはお電話済みの場合は大変申し訳ございません。</p>
@else
{!! nl2br(e($mail)) !!}
<p>すでに本メールが送信済みの場合は大変申し訳ございません。</p>
@endif
<p>■応募求人<br>
    【求人番号】：{{ $apply->jobitem->id }}<br>
    【求人URL】：<a href="{{ route('show.front.job_sheet.detail', $apply->jobitem) }}">{{ route('show.front.job_sheet.detail', $apply->jobitem) }}</a><br>
    【企業】：{{ $apply->jobitem->company->cname }}<br>
    【勤務先】：{{ $apply->jobitem->job_office }}<br>
    【職種】：{{ $apply->jobitem->job_type }}<br>
    【住所】：{{ $apply->jobitem->job_office_address }}<br>
    【採用担当】：{{ $apply->jobitem->company->employer->first_name }}<br>
    【連絡先電話番号】：{{ $apply->jobitem->company->full_phone }}</p>
<p>※応募した求人はマイページから確認できます。<br>
    <a href="{{ route('seeker.index.mypage') }}">{{ route('seeker.index.mypage') }}</a>
    <br>
    <p>＜ 運営情報 ＞<br>
        JOBCiNEMA<br>
        お問い合わせ : {{ config('mail.contact.address') }}<br>
        サイトURL : <a href="{{ url('/') }}">{{ url('/') }}</a>
