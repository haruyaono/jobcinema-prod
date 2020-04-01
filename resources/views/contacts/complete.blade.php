@extends('layouts.master')

@section('title', 'お問い合わせ完了')
@section('description', 'JOBCiNEMAに関するお問い合わせ完了')

@section('header')
  @component('components.header')
  @endcomponent
@endsection

@section('contents')
<!-- ここからメインコンテンツ -->
<div class="main-wrap">
<section class="main-section contact-section">
    <div class="inner">
    <div class="pad">
　    <h1><span class="ib-only-pc">求人サイト</span>JOBCiNEMAに関するお問い合わせ完了</h1>
      <p class="c-complete-textbox">お問い合わせが完了しました。<br>
入力頂いたメールアドレスへ確認のメールをお送りいたしましたのでご確認下さい。</p>
    </div> <!-- pad -->
    </div>
</section>
</div>
@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection

