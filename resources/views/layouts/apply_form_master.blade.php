<!DOCTYPE html>
<html lang="ja">
<head>
  <title>@isset ($title) {{$title}} | @endisset @yield('title')</title>
  <script defer src="{{ asset('js/app.js') }}"  ></script>
  
  @include('../partials.head')
</head>
<body class="jobApplyPage">
    <div class="wrap apply-wrap" id="app">
        <div class="contents">
            
            @yield('header')
            @yield('contents')
            @yield('footer')
        </div>
    </div> 

<script>
$(function() {
    $(".file-apload-form").submit(function() {
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
