@extends('layouts.master')

@section('title', 'ページが見つかりません')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.header')
  @endcomponent
@endsection

@section('contents')
<!-- パンくず -->
<div id="breadcrumb" class="bread only-pc">
<ol>
  <li>
    <a href="/">
      <i class="fa fa-home"></i><span>釧路の求人情報TOP</span>
    </a>
  </li>
  <li>
    <a>
    ページが見つかりません
    </a>
  </li>
</ol>
</div>

<!-- ここからメインコンテンツ -->
<div class="main-wrap">
	<!-- 絞り込み・検索エリア -->

	<!-- カスタム投稿の新着案件 10件 -->
	<section class="newjob-entry">
		<div class="inner">
			<div class="pad">
				<h2 class="txt-h2">エラー</h2>

				<div class="newjob-list">
					<p class="msg-404">ページが見つかりません。</p>

          <p class="linkbtn-404">
            <a href="/">トップページに戻る</a>
          </p>
				</div> <!-- newjob-list -->
			</div> <!-- pad -->
		</div> <!-- inner -->
	</section> <!-- newjob-entry -->


</div> <!-- main-wrap-->
@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection
