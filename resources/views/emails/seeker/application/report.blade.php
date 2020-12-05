<p>求人サイト JOBCiNEMA</p>
<p>{{ $apply->jobitem->employer->last_name }} {{ $apply->jobitem->employer->first_name }}様</p>
<p>この度は、{{ $apply->jobitem->company->cname }} 様がご掲載された求人の応募者が辞退したことをお知らせいたします。</p>

<p>つきましては、管理画面より応募者の辞退処理をお願いいたします。<br>
    該当の応募情報は下記に記載しております。<br>
</p>

<p>既に本メールが送信済み、または辞退処理済みの場合は大変申し訳ございません。</p>
<p>■辞退があった応募<br>
    【応募日】：{{ $apply->created_at->format('Y-m-d') }}<br>
    【雇用形態】：{{ $apply->jobitem->categories()->wherePivot('ancestor_slug', 'status')->first() !== null ? $apply->jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name : '' }}<br>
    【職種】：{{ $apply->jobitem->job_type }}<br>
    【勤務先名】：{{ $apply->jobitem->job_office }}<br>
    【応募者名】：{{ $apply->detail->full_name }}<br>
    【性別・年齢】：{{ $apply->detail->gender }}　{{ $apply->detail->age }}
</p>
<p>※応募情報は管理画面から確認できます。<br>
    <a href="{{ route('enterprise.index.mypage') }}">{{ route('enterprise.index.mypage') }}</a>
    <br>
</p>
<p>＜ 運営情報 ＞<br>
    JOBCiNEMA<br>
    お問い合わせ : {{ config('mail.contact.address') }}<br>
    サイトURL : <a href="{{ url('/') }}">{{ url('/') }}</a>
</p>
