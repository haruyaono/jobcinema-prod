<p>求人サイト JOBCiNEMA</p>
<p>JOBCiNEMAへの会員登録が完了しました。<br>
    下記内容をご確認ください。</p>

<p>■ログイン情報<br>
    ログインID：{{ $user->email }}<br>
    パスワード：（安全上、非表示にしています）</p>

<p>＜ 運営情報 ＞<br>
    JOBCiNEMA<br>
    お問い合わせ : {{ config('mail.contact.address') }}<br>
    サイトURL : <a href="{{ url('/') }}">{{ url('/') }}</a>
</p>
