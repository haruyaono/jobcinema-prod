@section('header')
<!-- ヘッダー -->
<header class="header header_apply">
    <div class="inner">
        <div class="header-top">
            @if(Request::is('/')) {{-- トップが表示されている場合、タイトルを H1 で表示 --}}
            <h1 class="logo"><a href="/"><img src="{{ asset('/img/common/jobcinema_rogo_re.png') }}" alt=""></a></h1>
            @else
            <div class="logo"><a href="/"><img src="{{ asset('/img/common/jobcinema_rogo_re.png') }}" alt=""></a></div>
            @endif
        </div>
    </div> <!-- inner -->
</header> <!-- /header -->
@endsection
