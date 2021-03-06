@section('header')
<!-- ヘッダー -->
<header class="header">
    <div class="inner">
        <div class="header-top cf">
            <div class="companyHeaderLeft floatL">
                @if (Auth::guard('employer')->check())
                <a href="{{ route('enterprise.index.mypage') }}" class="h3 mb-0 font-white mt-2">{{ Auth::guard('employer')->user()->company->cname ?: 'ゲスト' }}様の管理ページ</a>
                @else
                <div class="logo"><a href="/"><img src="{{ asset('/img/common/jobcinema_rogo_re.png') }}" alt=""></a></div>
                @endif
            </div>
            <div class="emp-header-right floatR">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            管理メニュー<span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown1">
                            @if (Auth::guard('employer')->check())
                            <a class="dropdown-item" href="{{ route('enterprise.index.joblist') }}">
                                {{ __('求人票を作成・確認') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('enterprise.index.application') }}">
                                {{ __('応募者を見る') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('enterprise.edit.profile') }}">
                                {{ __('企業データの編集') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('employer.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('ログアウト') }}
                            </a>
                            <form id="logout-form" action="{{ route('employer.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div> <!-- inner -->
</header> <!-- /header -->
@endsection
