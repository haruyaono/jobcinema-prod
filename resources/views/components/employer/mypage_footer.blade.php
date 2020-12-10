@section('footer')
<footer class="footer">
  <div class="inner">
    <div class="container">
      <div class="footer-bottom">
        <ul class="emp-footer-list">
          <li><i class="fas fa-angle-right mr-1"></i><a href="{{ route('show.lp') }}" target="_blank">求人広告掲載について</a></li>
          <li><i class="fas fa-angle-right mr-1"></i><a href="/contact_e">お問い合わせ</a></li>
        </ul>
        <div class="footer-bottom-left">
          <img src="{{ asset('/img/common/jobcinema_rogo_re.png') }}" alt="">
          <p class="copy">©JOB CiNEMA</p>
        </div>
      </div>
    </div>
  </div>
</footer><!-- /footer -->

@endsection
