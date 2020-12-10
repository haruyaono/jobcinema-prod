@section('footer')
<?php
$routeName = Route::currentRouteName();
$isDetail = $routeName === 'show.front.job_sheet.detail' ? true : false;
?>
<footer class="footer">

  <div class="inner">
    <div class="container only-pc">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <h3 class="footer-heading mb-4">求人をお探しの方へ</h3>
              <ul class="list-unstyled footer-list-left">
                <li><a href="/beginners">初めての方へ</a></li>
                <li><a href="/terms_service" target="_blank">利用規約</a></li>
                <!-- <li><a href="#">プライバシーポリシー</a></li> -->
                <li><a href="/manage_about">運営について</a></li>
                <li><a href="/ceo">代表挨拶</a></li>
                <li><a href="{{ route('index.front.job_sheet.search') }}">求人を探す</a></li>
                <li><a href="{{ route('contact.s.get') }}">お問い合わせ</a></li>
                <!-- <li><a href="#">サイトマップ</a></li> -->
              </ul>
            </div>
            <div class="col-md-6">
              <h3 class="footer-heading mb-4">採用担当の方へ</h3>
              <ul class="list-unstyled">
                <li><a href="{{ route('show.lp') }}" target="_blank">求人掲載をお考えの方はこちら</a></li>
                <li><a href="{{ route('employer.login') }}">求人掲載企業様ログイン</a></li>
                <li><a href="{{ route('contact.e.get') }}">お問い合わせ</a></li>
                <li><a href="/terms_service_e" target="_blank">利用規約</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-top-item-sp only-sp">
      <ul>
        <li><a href="/beginners">初めての方へ</a></li>
        <li><a href="/manage_about">運営について</a></li>
        <li><a href="{{ route('contact.s.get') }}">お問い合わせ</a></li>
      </ul>
      <ul>
        <li><a href="/terms_service" target="_blank">利用規約</a></li>
        <li><a href="{{ route('show.lp') }}">求人掲載をお考えの方はこちら</a></li>
        <li><a href="{{ route('employer.login') }}">求人掲載企業様ログイン</a></li>
      </ul>
    </div>

    <div class="footer-bottom">
      <div class="footer-bottom-left">
        <img src="{{ asset('/images/jobcinema_rogo_re.png') }}" alt="">
        <p class="copy">©JOB CiNEMA</p>
      </div>
    </div>
  </div>

</footer><!-- /footer -->
<div class="to-top {{ $isDetail ? 'isDetail' : '' }}"><i class="fas fa-angle-up"></i></div>


@endsection
