@section('header')
<!-- ヘッダー -->
	<header class="header">
		<div class="inner">
            <div class="header-top">
                @if(Request::is('/')) {{-- ホームが表示されている場合、ブログタイトルを H1 で表示 --}}
                        <h1 class="logo"><a href="/"><img src="{{ asset('/uploads/images/jobcinema_rogo_re.png') }}" alt=""></a></h1>
                        @else
                        <div class="logo"><a href="/"><img src="{{ asset('/uploads/images/jobcinema_rogo_re.png') }}" alt=""></a></div>
                @endif
                <div class="emp-header-right only-pc">
                    <p>サポート対応<span class="header-tel">080-8297-8600</span><span>(受付時間: 〇〇〜〇〇)</span></p>        
                </div>
            </div>
		</div> <!-- inner -->
    </header> <!-- /header -->
    <div class="emp-header-right only-sp">
        <p>サポート対応<span class="header-tel">080-8297-8600</span><br>
        <span>(受付時間: 〇〇〜〇〇)</span></p>        
    </div>
    
@endsection
