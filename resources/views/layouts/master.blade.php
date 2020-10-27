<!DOCTYPE html>
<html lang="ja">

<head>
    <title>@isset ($title) {{$title}} | @endisset @yield('title')</title>
    @include('../partials.head')
    <script defer src="{{ mix('js/app.js') }}"></script>
</head>

<body>
    <!-- 動画背景 -->
    <div class="wrap" id="app">
        <!-- 背景用の動画ファイル -->
        @if(url()->current() != url('lp') && url()->current() != url('contact'))
        <video id="bg-video" src="{{ asset('/uploads/images/back-retro.mp4') }}" autoplay loop muted></video>
        @endif
        <!-- 背景上に表示させるコンテンツ -->
        <div class="contents @if(url()->current() == url('lp')) lp-contents @endif">

            <div class="wide-notice-overlay">
                <div class="wide-notice-layout">
                    <div class="notice-box">
                        <p>現在、ベータ版を公開中です。</p>
                        <p>不具合が発生した場合はお問い合わせよりご報告ください。</p>
                    </div>
                    <span class="notice-close"></span>
                </div>
            </div>
            <!-- ヘッダー -->
            @yield('header')
            @yield('contents')
            @yield('footer')
            <input type="hidden" id="env_input" name="env" value="{{config('app.env')}}">
            <input type="hidden" id="file_path" name="file_path" value="@if(config('app.env') == 'production'){{config('app.s3_url')}}@else{{ config('app.s3_url_local')}}@endif{{config('fpath.job_sheet_img')}}">
        </div><!-- contents -->
    </div> <!-- wrap -->
    @yield('js')
    <script defer src="{{ asset('js/main.js') }}"></script>
</body>

</html>
