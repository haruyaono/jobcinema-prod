@section('header')
<!-- ヘッダー -->
	<header class="header">
		<div class="inner">
      <div class="header-top">
      @if(Auth::guard()->check() == 1)
      <a class="p-favorite-fixed-nav clearfix" id="js-favorite-fixed-nav" href="/keeplist"><img class="header-sp-keep-icon" src="{{asset('/uploads/images/header-keep-icon.png')}}" alt="キープ"><em class="u-font-xl" id="js-fixed-favorite-num">{{Auth::user()->favourites->count()}}</em>&nbsp;件キープ中</a>
     @endif
        @if(Request::is('/'))
				<h1 class="logo"><a href="/"><img src="{{ asset('/uploads/images/jobcinema_rogo_re.png') }}" alt=""></a></h1>
				@else
				<div class="logo"><a href="/"><img src="{{ asset('/uploads/images/jobcinema_rogo_re.png') }}" alt=""></a></div>
        @endif
          <ul class="header-widget navbar-nav ml-auto">
            <!-- Authentication Links -->
            @if(Auth::guard()->check() == 0)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('無料会員登録') }}</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="{{ route('employer.register.index') }}">{{ __('求人企業様のご登録') }}</a>
                </li>
            @else
                <li>
                    @if (Auth::guard()->check())
                      <a href="{{route('mypages.index') }}" >
                          @if(!empty(Auth::user()->last_name) && !empty(Auth::user()->first_name))
                          <i class="fas fa-user mr-1"></i>{{Auth::user()->last_name}}さん <span class="caret"></span>
                          @else
                          <i class="fas fa-user mr-1"></i>ゲストさん<span class="caret"></span>
                          @endif
                      </a>
                    @endif
                
                </li>
                <li>
                  @if (Auth::guard()->check())
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                        {{ __('ログアウト') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                  @endif
                </li>

                <li><a href="/contact_s">お問い合わせ</a></li> 
            @endif
          </ul>
      </div>
        <!-- globalnav -->
			<nav class="gnav">
				<ul>
						<li><a href="/jobs/search/all">求人を探す</a></li>
						<li><a href="/lp" target="_blank">広告掲載をお考えの方へ</a></li>
						<li><a href="/published-contact">お祝い金申請</a></li>
            <li><a href="{{route('keeplist')}}">キープリスト</a></li>
            <li><a href="/contact_s">お問い合わせ</a></li> 
				</ul>
      </nav>

      <!-- ログインボタン -->
      <div class="header-sp-login">
        @if (Auth::guard()->check())
          <a class="header-sp-login-link" href="{{route('mypages.index') }}" >
              <!-- @if(!empty(Auth::user()->last_name) && !empty(Auth::user()->first_name))
              <i class="fas fa-user mr-1"></i>{{Auth::user()->last_name}}さん <span class="caret"></span>
              @else
              <i class="fas fa-user mr-1"></i>ゲストさん<span class="caret"></span>
              @endif -->
              <i class="fas fa-user"></i><span class="caret"></span>
          </a>
        @else
        <a class="header-sp-login-link" href="/members/login">
         ログイン
        </a>
        @endif
      </div>
      <!-- キープリスト -->
      <div class="header-sp-keep">
        <a class="header-sp-keep-link" href="/keeplist">
          <img class="header-sp-keep-icon" src="{{asset('/uploads/images/header-keep-icon.png')}}" alt="キープ">
          <span class="sp-header-nav-text">キープ</span>
        </a>
      </div>
      <!-- ハンバーガー -->
      <nav id="nav-drawer">
        <input id="nav-input" type="checkbox" class="nav-unshown">
        <label id="nav-open" for="nav-input"><span></span></label>
        <span class="sp-header-nav-text">メニュー</span>
        <label class="nav-unshown" id="nav-close" for="nav-input"></label>
        <div id="nav-content">
          <p class="drawer-sub-ttl">サイトについて<label class="close" for="nav-input">
            <span></span>
          </label></p>
          <ul class="drawer-list">
            <li><a href="/">JOB CiNEMAトップ</a></li>
            <li><a href="/beginners">初めての方へ</a></li>
            <li><a href="/jobs/search/all">釧路の求人を探す</a></li>

          </ul>
          <p class="drawer-sub-ttl">仕事を探す</p>
          <ul class="drawer-list">
            <li><a href="{{route('allcat', ['type'])}}">職種から探す</a></li>
            <li><a href="{{route('allcat', ['area'])}}">エリアから探す</a></li>
            <li><a href="{{route('allcat', ['hourly_salary'])}}">時給から探す</a></li>
          </ul>
            <p class="drawer-sub-ttl">その他</p>
            <ul class="drawer-list">
            <li><a href="/lp" target="_blank">求人掲載をお考えの方はこちら</a>
            </li>
            <li><a href="/contact_s">お問合わせはこちら</a></li>
            </ul>
        </div>
      </nav>
		</div> <!-- inner -->
	</header> <!-- /header -->
@endsection
