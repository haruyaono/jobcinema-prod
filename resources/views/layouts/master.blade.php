<!DOCTYPE html>
<html lang="ja">
<head>
  <title>@isset ($title) {{$title}} | @endisset @yield('title')</title>
  @include('../partials.head')
  <script defer src="{{ asset('js/app.js') }}" ></script>
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
</div><!-- contents -->
</div> <!-- wrap -->
@yield('js')
<!-- <script defer src="{{ asset('js/main.js') }}" ></script> -->
<script>

$(function() {
    $(".file-upload-form").submit(function() {
        var self = this;
        $(":submit", self).prop("disabled", true);
        setTimeout(function() {
            $(":submit", self).prop("disabled", false);
        }, 10000);
    });
});
</script>
</body>
</html>
