@extends('layouts.master')

@section('title', 'JOBCiNEMAに求人広告の掲載をご検討中の方へ')
@section('description', 'JOBCiNEMAの求人広告の料金はこちら')

@section('header')
<header class="header">
  <div class="inner">
    <div class="logo"><a href="/"><img src="{{ asset('/img/common/jobcinema_rogo_re.png') }}" alt="JOBCiNEMA"></a></div>
    <div class="header-right">
      <a href="contact_e" class="form-app">お問い合わせ</a>
    </div>
  </div> <!-- inner -->
</header> <!-- /header -->
@endsection

@section('contents')
<main class="main-lp">
  <div class="inner">
    <div class="pad">
      <h1 style="font-size: 2rem; font-weight: bolder;">アルバイトの求人掲載でお困りの企業様へ</h1>
      <img class="lp-main-image" src="{{ asset('/img/common/job-cinema_lp.png') }}" alt="JOB CiNEMA">

      <section class="section1">
        <h2><i class="fas fa-video faa-spin animated"></i>「JOB CiNEMA」の強みは？</h2>
        <p class="section1-p1">採用まで費用が<span>"０円"</span>である採用課金プラン!</p>
        <p class="section1-p2">費用を抑えたい企業向けのサービスです</p>
        <div class="plan plan1">
          <p class="plan-title">採用課金プランのしくみ</p>
          <p>採用して初めて料金が発生するので、<br class="only-sp">無駄なお金がかかりません。</p>
          <p>採用までの期間中は、</p>
          <ol>
            <li>ゆっくり選考できる</li>
            <li>面接・書類選考は無制限</li>
            <li>搭載費用が無料</li>
          </ol>
          <p>リスクを極限まで下げております。</p>
        </div>
        <div class="plan plan2">
          <p class="plan-title">採用課金プランの費用</p>
          <p>1人採用で</p>
          <div class="plan-list">
            <div class="plan-cost">
              <p>正社員</p>
              <p><span>12</span>万円</p>
            </div>
            <div class="plan-cost">
              <p>アルバイト</p>
              <p><span>3</span>万円</p>
            </div>
          </div>
        </div>
      </section>
      <section class="section2">
        <h2><i class="fas fa-video faa-spin animated"></i>「ユーザーファーストなシステムを<br class="only-sp">目指しております」</h2>
        <p class="section1-p2">JOB CiNEMAは、企業様のストレスを最小限にするために<br>３つのポイントを実践しています。</p>
        <div class="point-list">
          <div class="point">
            <img src="{{ asset('/img/common/point1.png') }}" alt="JOB CiNEMA">
            <p>管理画面からいつでも求人票編集・停止できます。<br>急な募集でもOK！</p>
          </div>
          <div class="point">
            <img src="{{ asset('/img/common/point2.png') }}" alt="JOB CiNEMA">
            <p>採用して初勤務が終わるまで料金はかかりません。<br>無駄な損失を無くし、マッチした人のみ採用できます。</p>
          </div>
          <div class="point">
            <img src="{{ asset('/img/common/point3.png') }}" alt="JOB CiNEMA">
            <p>管理画面からいつでも求人票の編集が可能です。<br>募集情報を変更したい時も、すぐに対応できます。</p>
          </div>
        </div>
      </section>
      <section class="section3">
        <h2><i class="fas fa-video faa-spin animated"></i>初回ご掲載までの流れ</h2>
        <div class="flow">
          <p><span>1</span>企業会員登録</p>
          <p>「会員登録」ボタンから仮登録後、メールに記載された本登録用URLから必要事項を入力し本登録。</p>
        </div>
        <img src="{{ asset('/img/common/flow1.png') }}" alt="JOB CiNEMA">
        <div class="flow">
          <p><span>2</span>求人票作成・審査</p>
          <p>ログイン後の企業マイページから求人票を作成し掲載申請できます。「申請中」は、当方で審査いたします。</p>
        </div>
        <img src="{{ asset('/img/common/flow2.png') }}" alt="JOB CiNEMA">
        <div class="flow">
          <p><span>3</span>掲載スタート</p>
          <p>無事、求人票の審査が通った時点で掲載がスタート！</p>
        </div>
        <p class="app-concept">求人ページを公開すると、貴社の求人へ応募があります。<br>
          貴社の選考フローに沿って、応募者様へのご対応をお願いいたします。</p>
        <a href="/employer/getpage" class="form-app">無料企業登録</a>
      </section>
      <section class="section4">
        <h2><i class="fas fa-video faa-spin animated"></i>よくある質問</h2>
        <div class="q-a">
          <p class="q">求人票を申請して何日で掲載されますか？</p>
          <p class="a">申請からご掲載まで、<span>最短で即日</span>、遅くとも5営業日以内になります。</p>
        </div>
        <div class="q-a">
          <p class="q">JOB CiNEMAの応募者は、どんな層が多いですか？</p>
          <p class="a">管理者に現役大学生もいるため、<span>大学生や20代前半</span>、への訴求には自信を持っています。</p>
        </div>
        <div class="q-a">
          <p class="q">JOB CiNEMAはどのような媒体に対応していますか？</p>
          <p class="a"><span>パソコン・タブレット・スマートフォン</span>に対応しています。</p>
        </div>
        <div class="q-a">
          <p class="q">採用課金プランを利用して、採用が決まらなかった場合、費用はかかりますか？</p>
          <p class="a">採用課金プランの場合、採用が決まらなかった場合は<span>費用は一切かかりません。</span></p>
        </div>
        <div class="q-a">
          <p class="q">採用課金プランの場合、求人の掲載期間の制限はありますか？</p>
          <p class="a"><span>掲載期間の制限はございません。</span>採用が決まるまでは費用はかかりませんので、安心してゆっくりとご掲載いただけます。</p>
        </div>
        <div class="q-a">
          <p class="q">求人が必要なくなった場合、すぐに求人をストップできますか？</p>
          <p class="a">掲載開始・停止の切り替えは、管理画面から簡単に行えます。人が必要な場合のみ、求人広告を掲載することが可能です。</p>
        </div>
        <div class="q-a">
          <p class="q">費用発生のタイミングは？</p>
          <p class="a">採用決定時点で費用は発生致します。</p>
        </div>
        <div class="q-a">
          <p class="q">料金の支払い方法は？</p>
          <p class="a">サービス料金の支払いは毎月末日締めとし、お客様は、当方の算出した当月分のサービス料金を翌月15日（支払い期日が金融機関の定休日の場合は翌営業日）までに、当方の指定する銀行口座に振込送金して支払うものとします。なお、振込手数料はお客様の負担とします。</p>
        </div>
        <div class="q-a">
          <p class="q">採用者への「お祝い金」とは？</p>
          <p class="a">採用された方全員に、JOB CiNEMAから「お祝い金」をプレゼントしています。そのため、他媒体で応募をするよりも、多くの求職者の注目を集めています。</p>
        </div>
      </section>
    </div>
  </div>
</main>
@endsection

@section('footer')
<footer class="footer">
  <div class="inner">
    <div class="footer-top-item-sp only-sp">
      <ul>
        <li><a href="/terms_service_e" target="_blank">利用規約</a></li>
        <li><a href="/profile">運営について</a></li>
        <li><a href="/">サイトマップ</a></li>
      </ul>
      <ul>
        <li><a href="/contact_e">お問い合わせ</a></li>
        <li><a href="/lp">求人掲載をお考えの方はこちら</a></li>
      </ul>
    </div>
    <div class="footer-bottom footer-bottom-lp">
      <div class="footer-bottom-left">
        <img src="{{ asset('/img/common/jobcinema_rogo_re.png') }}" alt="">
        <p class="copy">©{{ config('app.name')}}</p>
      </div>
      <div class="footer-bottom-right ib-only-pc">
        <ul>
          <li><a href="/terms_service_e" target="_blank">利用規約</a></li>
          <li><a href="/contact_e">お問い合わせ</a></li>
          <li><a href="/">サイトマップ</a></li>
          <li><a href="/lp">求人掲載をお考えの方はこちら</a></li>
        </ul>
      </div>
    </div>
  </div><!-- /inner -->
</footer><!-- /footer -->
<div class="to-top"><i class="fas fa-angle-up"></i></div>
@endsection
