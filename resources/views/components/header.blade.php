<?php
if (\Auth::guard('seeker')->check()) {
  $jobFavCount = \App\Models\User::checkFavCount();
} else {
  $jobFavCount = 0;
}
?>
@section('header')
<!-- ヘッダー -->
<header class="header">
  <div class="inner">
    <div class="header-top">
      @if(Request::is('/'))
      <h1 class="logo"><a href="/"><img src="{{ asset('/img/common/jobcinema_rogo_re.png') }}" alt=""></a></h1>
      @else
      <div class="logo"><a href="/"><img src="{{ asset('/img/common/jobcinema_rogo_re.png') }}" alt=""></a></div>
      @endif
      <ul class="header-widget navbar-nav ml-auto">
        <!-- Authentication Links -->
        @if(!Auth::guard('seeker')->check())
        <li class="nav-item">
          <a class="nav-link" href="{{ route('seeker.login') }}">{{ __('ログイン') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('seeker.register') }}">{{ __('無料会員登録') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('employer.register.index') }}">{{ __('求人企業様のご登録') }}</a>
        </li>
        @else
        <li>
          <a href="{{ route('seeker.index.mypage') }}">
            @if(!empty(Auth::guard('seeker')->user()->last_name) && !empty(Auth::guard('seeker')->user()->first_name))
            <i class="fas fa-user mr-1"></i>{{ Auth::guard('seeker')->user()->last_name }}さん <span class="caret"></span>
            @else
            <i class="fas fa-user mr-1"></i>ゲストさん<span class="caret"></span>
            @endif
          </a>
        </li>
        <li>
          <a href="{{ route('seeker.logout') }}" onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
            {{ __('ログアウト') }}
          </a>

          <form id="logout-form" action="{{ route('seeker.logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
        <li><a href="/contact_s">お問い合わせ</a></li>
        @endif
      </ul>
    </div>
    <!-- globalnav -->
    <nav class="gnav">
      <ul>
        <li><a href="{{ route('index.front.job_sheet.search') }}">求人を探す</a></li>
        <li><a href="{{ route('lp.get')}}" target="_blank">広告掲載をお考えの方へ</a></li>
        <li><a href="{{ route('create.front.reward') }}">お祝い金申請</a></li>
        <li><a href="{{ route('index.front.job_sheet.keeplist') }}" class="saveWrap">キープリスト</a></li>
        <li><a href="{{ route('index.front.job_sheet.history') }}">閲覧履歴</a></li>
      </ul>
    </nav>
    <div class="header-sp-right">
      <!-- キープリスト -->
      <div class="header-sp-keep">
        <a class="header-sp-keep-link cf" href="/keeplist">
          <i class="fas fa-star star floatL"></i>
          <div class="saveWrap floatL">
            <span class="save">保存</span>
            <favourite-count-component :count={{ $jobFavCount }} place="header"></favourite-count-component>
          </div>
        </a>
      </div>
      <!-- ハンバーガー -->
      <div class="fullHeaderMenu">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>

  </div> <!-- inner -->
</header> <!-- /header -->
<div class="hamburgerLogout">
  <div class="hamburgerLogoutlayer">
    <div class="hamburgerLogoutWrap">
      <div class="hamburgerLogoutInner">
        <header class="hamburgerLogoutHeader">
          <div class="hamburgerLogoutHeaderClossMenuWrap">
            <span class="hamburgerLogoutHeaderClossInner">
              <div></div>
              <div></div>
              <div></div>
            </span>
          </div>
        </header>
        <div class="hamburgerLogoutMainWrap">
          @if(Auth::guard('seeker')->check())
          <div class="hamburgerLoginDisplayNameWrap">
            <div class="hamburgerLoginDisplayNameWrapLeft">
              <div class="userIconWrap"><i class="fas fa-user mr-1"></i></div>
              <p>ようこそ</p>
            </div>
            <div class="hamburgerLoginDisplayNameWrapRight overflowH">
              @if(!empty(Auth::guard('seeker')->user()->last_name) && !empty(Auth::guard('seeker')->user()->first_name))
              <p class="floatL lastname">{{ Auth::guard('seeker')->user()->last_name }}{{ Auth::guard('seeker')->user()->first_name }}</p>
              @else
              <p>ゲスト</p>
              @endif
              <p class="floatL">さん</p>
            </div>
          </div>
          @else
          <ul class="hamburgerLogoutKaiinLoginBtnWrap overflowH">
            <li class="hamburgerLogoutBtnList floatL"><a class="hamburgerLogoutBtn" href="{{ route('seeker.register') }}">会員登録</a></li>
            <li class="hamburgerLogoutloginBtnPcList floatL"><a class="hamburgerLogoutloginBtnPc" href="{{ route('seeker.login') }}">ログイン</a></li>
          </ul>
          @endif
          <div class="hamburgerLogoutMyMenuAreaWrap overflowH">
            <div class="hamburgerLogoutMyMenuAreaInner floatLPc">
              <p class="hamburgerLogoutMenuSubheading">マイメニュー</p>
              <ul class="hamburgerLogoutMyMenuLink">
                <li>
                  <a class="hamburgerLogoutOsiraseWrap" href="{{ route('info.get') }}">お知らせはありません</a>
                  <p class="hamburgerLogoutMenuCount">0</p>
                </li>
                <li class="hamburgerLoginMyMenuLinkList">
                  <a class="hamburgerLogoutClipJob" href="{{ route('index.front.job_sheet.keeplist') }}">保存したお仕事</a>
                  <favourite-count-component :count={{ $jobFavCount }} place="hamburger"></favourite-count-component>
                </li>
                @if(Auth::guard('seeker')->check())
                <li class="hamburgerLoginMyMenuLinkList">
                  <a class="hamburgerLoginApplicationMypage" href="{{ route('seeker.index.mypage') }}">マイページ</a>
                </li>
                @endif
              </ul>
            </div>
            <div class="hamburgerLogoutJobWrap floatLPc">
              <p class="hamburgerLogoutJobSubheading">お仕事を探す</p>
              <ul class="hamburgerLogoutJobInner">
                <li class="hamburgerLogoutJobItem"><a href="{{ route('index.front.category', ['type']) }}">職種から探す</a></li>
                <li class="hamburgerLogoutJobItem"><a href="{{ route('index.front.category', ['area']) }}">エリアから探す</a></li>
                <li class="hamburgerLogoutJobItem hamburgerLogoutJobItemlower"><a href="{{ route('index.front.category', ['salary']) }}">給与から探す</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="hamburgerLogoutInclude7Wrap">
          <div class="hamburgerLogoutInclude7BannerAppHelpSitemapWrap">
            <div class="hamburgerLogoutInclude7HelpSitemapLogoutWrap">
              <div class="menuInfoWrap">
                <a class="Include7Help" href="{{ route('contact.s.get') }}">ヘルプ/お問い合わせ</a>
                <!-- <a class="Include7Sitemap" href="/sitemap.html">サイトマップ</a> -->
                @if(Auth::guard('seeker')->check())
                <a class="Include7Help" href="{{ route('seeker.logout') }}" onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                  {{ __('ログアウト') }}
                </a>

                <form id="logout-form" action="{{ route('seeker.logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
