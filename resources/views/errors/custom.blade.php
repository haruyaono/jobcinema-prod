@extends('layouts.master')

@section('title', 'JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.header')
  @endcomponent
@endsection

@section('contents')

<!-- ここからメインコンテンツ -->
<div class="main-wrap">
	<!-- 絞り込み・検索エリア -->

	<!-- カスタム投稿の新着案件 10件 -->
	<section class="main-section error-section">
		<div class="inner">
			<div class="pad">
        <div class="userErrorField">
        @if($error_name === 'NotAppliedJob')
          <p class="userErrorFieldTxt">
          <i class="fas fa-exclamation-circle noteIcon"></i> <em>あなたは既に、この求人に応募しています</em></p><p>連絡先(メールアドレス・電話番号）の変更や、応募完了メールが届かない場合、<br>応募先から連絡がこない場合等は、<a href="{{route('contact.s.get')}}" class="txt-blue-link">こちら</a>からお問い合わせください。
          </p>
        @endif
        </div>
			</div> <!-- pad -->
		</div> <!-- inner -->
	</section> <!-- main-section -->


</div> <!-- main-wrap-->
@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection
