@extends('layouts.employer_mypage_master')


@section('title', 'ページが見つかりません')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.employer.mypage_header')
  @endcomponent
@endsection

@section('contents')
@php
$status_code = $exception->getStatusCode();
$message = $exception->getMessage();

if (! $message) {
    switch ($status_code) {
        case 400:
            $message = 'Bad Request';
            break;
        case 401:
            $message = '認証に失敗しました';
            break;
        case 403:
            $message = 'アクセス権がありません';
            break;
        case 404:
            $message = '存在しないページです';
            break;
        case 408:
            $message = 'タイムアウトです';
            break;
        case 414:
            $message = 'リクエストURIが長すぎます';
            break;
        case 419:
            $message = '不正なリクエストです';
            break;
        case 500:
            $message = 'Internal Server Error';
            break;
        case 503:
            $message = 'Service Unavailable';
            break;
        default:
            $message = 'エラー';
            break;
    }
}
@endphp
<!-- パンくず -->
<div id="breadcrumb" class="bread only-pc">
<ol>
  <li>
    <a href="/">
     <span>釧路の求人情報TOP</span>
    </a>
  </li>
  <li>
    {{ $message }}
  </li>
</ol>
</div>

<!-- ここからメインコンテンツ -->
<div class="main-wrap">
	<!-- 絞り込み・検索エリア -->

	<!-- カスタム投稿の新着案件 10件 -->
	<section class="main-section error-section">
		<div class="inner">
			<div class="pad">
				<h2 class="txt-h2 left-border-h2">エラー</h2>
        <div class="text-center my-5">
          <p class="my-5 h3">{{ $message }}</p>
          <a class="btn btn-yellow my-5" href="/">トップページに戻る</a>
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
