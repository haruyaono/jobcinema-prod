@extends('layouts.master')

@section('title', 'JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.header')
@endcomponent
@endsection

@section('contents')
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
<div class="main-wrap">
  <section class="main-section error-section">
    <div class="inner">
      <div class="pad">
        <h2 class="txt-h2 left-border-h2">エラー</h2>
        <div class="text-center my-5">
          <p class="my-5 h3">
            @if($error_name === 'NotAppliedJob')
            この求人は応募済みです
            @else
            エラー
            @endif
          </p>
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
