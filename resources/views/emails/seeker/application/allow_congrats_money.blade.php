<p>求人サイト JOBCiNEMA</p>
<p>{{ $apply->user->full_name }}様</p>
<p>下記のご応募{{ $apply->jobitem->company->cname }} にあたりお祝い金申請のご案内をいたします。</p>

<p> <a href="{{ route('seeker.index.mypage') }}">マイページ</a>にログイン後、下記のお祝い金申請フォームからお祝い金の申請をして下さい。<br>
    <!-- <a href="{{ route('create.front.reward') }}">{{ route('create.front.reward') }}</a> -->
</p>

<p>既に本メールが送信済みの場合は大変申し訳ございません。</p>

<p>■応募情報<br>
    【応募日】：{{ $apply->created_at->format('Y-m-d') }}<br>
    【雇用形態】：{{ $apply->jobitem->categories()->wherePivot('ancestor_slug', 'status')->first() !== null ? $apply->jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name : '' }}<br>
    【職種】：{{ $apply->jobitem->job_type }}<br>
    【勤務先名】：{{ $apply->jobitem->job_office }}<br>
    【応募者名】：{{ $apply->detail->full_name }}<br>
    【性別・年齢】：{{ $apply->detail->gender }}　{{ $apply->detail->age }}
</p>
<p>＜ 運営情報 ＞<br>
    JOBCiNEMA<br>
    お問い合わせ : {{ config('mail.contact.address') }}<br>
    サイトURL : <a href="{{ url('/') }}">{{ url('/') }}</a>
</p>
