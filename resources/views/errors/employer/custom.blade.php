@extends('layouts.employer_mypage_master')

@section('title', 'JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.employer.mypage_header')
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
          <p class="userErrorFieldTxt">
            <i class="fas fa-exclamation-circle noteIcon"></i> 
            <em>
            @if($error_name === 'NotApplicatUser')
              該当する応募ユーザーが存在しません。
            @elseif($error_name === 'NotJobItem')
              該当する求人が存在しません。
            @elseif($error_name === 'NotAppliedJobItem')
              応募された求人が存在しません。
            @endif
            </em>
          </p>
          <p><a href="#" onclick="javascript:window.history.back(-1);return false;" class="txt-blue-link">戻る</a></p>
        </div>
			</div> <!-- pad -->
		</div> <!-- inner -->
	</section> <!-- main-section -->


</div> <!-- main-wrap-->
@endsection

@section('footer')
  @component('components.employer.mypage_footer')
  @endcomponent
@endsection
