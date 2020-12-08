@extends('layouts.master')

@section('title', '運営について')
@section('description', 'JOBCiNEMAの運営について')

@section('header')
@component('components.header')
@endcomponent
@endsection

@section('contents')
<!-- パンくず -->
<div id="breadcrumb" class="bread only-pc">
  <ol class="list-decimal">
    <li>
      <a href="/">
        <i class="fa fa-home"></i><span>釧路の求人情報TOP</span>
      </a>
    </li>
    <li>
      <a>
        運営について
      </a>
    </li>
  </ol>
</div>
<!-- ここからメインコンテンツ -->
<div class="main-wrap">
  <section class="main-section static-page">
    <div class="inner">
      <div class="pad">
        　 <h1 class="mb-5">運営について</h1>
        <div class="page-textarea">
          <p>運営　釧路なび　JOB CiNEMA事業部</p>
          <p>代表　武田　将也</p>
          <p>所在地　〒085-0013　北海道釧路市栄町2丁目6-7すみ友館4F「ELFoo1」内</p>
          <p>電話番号　<a href="tel:080-8297-8600">080-8297-8600</a></p>
          <p>メールアドレス　<a href="mailto:masaya.takeda@kushiro-navi.com">masaya.takeda@kushiro-navi.com</a></p>
          <p class="page-section-close-btn">
            <a href="#" onclick="javascript:window.history.back(-1);return false;">戻る</a>
          </p>


        </div> <!-- pad -->
      </div>
  </section>
</div>
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection
