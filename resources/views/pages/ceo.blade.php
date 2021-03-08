@extends('layouts.master')

@section('title', '代表挨拶')
@section('description', 'JOBCiNEMA代表挨拶')

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
        代表挨拶
      </a>
    </li>
  </ol>
</div>
<!-- ここからメインコンテンツ -->
<div class="main-wrap">
  <section class="main-section static-page">
    <div class="inner">
      <div class="pad">
        <h1 class="mb-5">代表挨拶</h1>
        <div class="page-thum-wrap">
          <figure>
            <img src="{{ asset('/img/common/profile_1.png') }}" alt="代表の写真">
          </figure>
        </div>
        <div class="page-textarea">
          <p>自分を育ててくれた釧路に恩返しがしたい。僕の挑戦の原動力となっている想いです。僕は釧路に生まれ、21年間釧路に育てられました。</p>
          <p>19歳の春、僕は『釧路なび』というローカルメディアの運営を開始しました。理由は釧路にはびこる「釧路には何もない」という声。</p>
          <p>実際は他の地域にはない素敵な個人店が溢れているのに...</p>
          <p>観光客、そして釧路の人に釧路の魅力を伝えるため、自ら個人店へ取材に行きローカルメディアを運営していました。</p>
          <p>そして、取材の中で耳にしたのは「人材不足」という言葉。どこも若い人材の不足に苦しんでいました。</p>
          <p>僕は、現在休学中ですが、大学には籍を置いています。そして、もちろん現役の大学生とも縁があります。</p>
          <p>どうにか釧路の人材不足を少しでも解決できないか。その問いから生まれたのが『JOB CiNEMA』です。</p>
          <p>ただ、求人事業というのは「人材を募集する企業」と「働く先を探す求職者」の双方の悩みを解決しなければいけない事業。もちろん、信用がなければやっていける事業ではありません。</p>
          <p>釧路に生まれて21年の僕にはまだまだ信用はありません。傍から見れば無謀とも言える挑戦です。</p>
          <p>しかし、僕は挑戦し続けます。釧路の街に革命を起こしたいから。</p>
          <p>革命とは何か。僕は子供たちの未来に灯火を灯すことだと思っています。「釧路に住んでいても夢を見れる」という前例を作りたい。僕自身が未来の子供たちの灯火になりたい。その想いで今後も挑戦を続けていきたいと思います。</p>
        </div>

        <p class="mt-5 pl-3 text-right">代表　武田 将也</p>
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
