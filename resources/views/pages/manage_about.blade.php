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
          <p>運営　合同会社Libroth</p>
          <p>共同代表　菅原　京介</p>
          <p>共同代表　武田　将也</p>
          <p>所在地　〒085-0014　北海道釧路市末広町5丁目13</p>
          <p>電話番号　<a href="tel:080-9616-8651">080-9616-8651</a></p>
          <p>メールアドレス　<a href="mailto:bar.elfoo1@gmail.com">bar.elfoo1@gmail.com</a></p>
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
