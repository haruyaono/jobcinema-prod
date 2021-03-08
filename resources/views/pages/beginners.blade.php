@extends('layouts.master')

@section('title', 'JOBCiNEMAとは')
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
        JOBCiNEMAとは
      </a>
    </li>
  </ol>
</div>
<!-- ここからメインコンテンツ -->
<div class="main-wrap main-lp">
  <section class="main-section static-page about-page">
    <div class="inner">
      <div class="pad">
        <h1 class="ttl-lg">釧路の職場を上映する求人サイト<br>「JOB CiNEMA」</h1>
        <p class="beginners-intr">JOB CiNEMAは、北海道釧路の職場を上映する求人情報サイトです。アルバイト・パート・正社員などの求人情報や、バイト探しに役立つ情報をご紹介します。釧路地域で皆様のお仕事探しを豊富な情報でサポートします。</p>
        <div class="beginners-section beginners-flow">
          <h2>JOB CiNEMAの使い方</h2>
          <div class="flow-btn-wrap">
            <div class="flow-btn tab-current" id="company-btn">利用者様向け</div>
            <div class="flow-btn" id="customer-btn">企業様向け</div>
          </div>
          <div class="beginners-flow-text content-current" id="company-flow-text">
            <ul>
              <li>
                <div class="left">
                  <span class="step">STEP1</span>
                  <span class="image"><i class="far fa-paper-plane"></i></span>
                </div>
                <div class="right">
                  <p class="ttl">興味のあるお仕事に応募！</p>
                  <p class="desc">気になるお仕事を探して応募してみましょう！</p>
                </div>
              </li>
              <li>
                <div class="left">
                  <span class="step">STEP2</span>
                  <span class="image"><i class="fas fa-mobile-alt"></i></span>
                </div>
                <div class="right">
                  <p class="ttl">電話で面接を申し込む！</p>
                  <p class="desc">応募先の企業に電話をしましょう！</p>
                </div>
              </li>
              <li>
                <div class="left">
                  <span class="step">STEP3</span>
                  <span class="image"><i class="fas fa-walking"></i></span>
                </div>
                <div class="right">
                  <p class="ttl">内定が決まったらいざ出勤！</p>
                  <p class="desc">内定が決まったらマイページから採用判定をしましょう！</p>
                </div>
              </li>
              <li>
                <div class="left">
                  <span class="step">STEP4</span>
                  <span class="image"><i class="far fa-smile"></i></span>
                </div>
                <div class="right">
                  <p class="ttl">31日後にお祝い金を申請！</p>
                  <p class="desc">お祝い金申請メールが届いたらWeb申請をしてお金を受け取れるようにしましょう！</p>
                </div>
              </li>
            </ul>
          </div>
          <div class="beginners-flow-text" id="customer-flow-text">
            <ul>
              <li>
                <div class="left">
                  <span class="step">STEP1</span>
                  <span class="image"><i class="far fa-edit"></i></span>
                </div>
                <div class="right">
                  <p class="ttl">掲載のご登録・企業情報をご入力</p>
                  <p class="desc">求職者に魅力を伝えましょう！</p>
                </div>
              </li>
              <li>
                <div class="left">
                  <span class="step">STEP2</span>
                  <span class="image"><i class="far fa-smile-beam"></i></span>
                </div>
                <div class="right">
                  <p class="ttl">求人広告の公開</p>
                  <p class="desc">求人公開後は編集・公開停止・削除が可能です！<br>掲載中の求人は編集後、運営の承認なしで再掲載！</p>
                </div>
              </li>
              <li>
                <div class="left">
                  <span class="step">STEP3</span>
                  <span class="image"><i class="far fa-calendar-check"></i></span>
                </div>
                <div class="right">
                  <p class="ttl">求職者からのご連絡で面接日を決定</p>
                  <p class="desc">応募者からの連絡をお待ち下さい！</p>
                </div>
              </li>
              <li>
                <div class="left">
                  <span class="step">STEP4</span>
                  <span class="image"><i class="fas fa-hand-holding-heart"></i></span>
                </div>
                <div class="right">
                  <p class="ttl">採用！</p>
                  <p class="desc">採用判定が確定したら、管理画面から採用報告しましょう！<br>60日経過後も採用処理されていない応募は自動的に課金対象になります。</p>
                </div>
              </li>
              <li>
                <div class="left">
                  <span class="step">STEP5</span>
                  <span class="image"><i class="fas fa-hand-holding-usd"></i></span>
                </div>
                <div class="right">
                  <p class="ttl">採用後、2週間以内にお支払い(30日以内に辞めた場合はご返金)</p>
                  <p class="desc">応募者が辞職した場合はすぐに運営にご連絡ください！<br>30日経過後に辞職のご連絡があった場合でも課金対象となります。</p>
                </div>
              </li>
            </ul>
          </div>

          <div class="beginners-section beginners-feature">
            <h2>JOB CiNEMAの特徴</h2>
            <div class="feature-wrap">
              <div class="feature">
                <div class="ttl">求職者様向け</div>
                <ul>
                  <li>
                    <p>1. 職場の雰囲気を"動画"で見れる！</p>
                  </li>
                  <li>
                    <p>2. どの仕事でもお祝い金がもらえる！</p>
                  </li>
                  <li>
                    <p>3. 釧路専門の求人サイト！</p>
                  </li>
              </div>
              <div class="feature">
                <div class="ttl">企業様向け</div>
                <ul>
                  <li>
                    <p>1. 採用が決まるまで費用0円！</p>
                  </li>
                  <li>
                    <p>2. 24時間いつでもWEBから掲載可能！</p>
                  </li>
                  <li>
                    <p>3. 求職者への多彩なアプローチ方法！</p>
                  </li>
              </div>
            </div>

          </div> <!-- pad -->
          <div>
            <a href="{{ route('index.front.job_sheet.search') }}" class="btn btn-yellow my-5">求人を探してみる！</a>
          </div>
        </div>
  </section>
</div>
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection

@section('js')
<script>
  $(function() {
    $('.flow-btn').click(function() {
      var index = $('.flow-btn').index(this);
      $('.beginners-flow-text').css('display', 'none');
      $('.beginners-flow-text').eq(index).css('display', 'block');
      $('.flow-btn').removeClass('tab-current');
      $(this).addClass('tab-current');
    });
  });
</script>

@endsection
