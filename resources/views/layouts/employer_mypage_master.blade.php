<!DOCTYPE html>
<html lang="ja">
<head>
  <title>@isset ($title) {{$title}} | @endisset @yield('title')</title>
  
  @include('../partials.head')
</head>
<body class="employer-mypage-body">
    <div class="wrap e-wrap" id="app">
        <div class="contents">
            
            @yield('header')
            @yield('contents')
            @yield('footer')
        </div>
    </div> 
<script defer src="{{ asset('js/main.js') }}"></script>
<script>
    $(function() {
        $(".file-apload-form").submit(function() {
            var self = this;
            $(":submit", self).prop("disabled", true);
            setTimeout(function() {
                $(":submit", self).prop("disabled", false);
            }, 10000);
        });

        $('.emp-header-right #navbarDropdown').click(function() {
            $('.emp-header-right .dropdown-menu').slideToggle();
            return false;
        });

        

    });
</script>
<script language="JavaScript">

    $('#close_button').click(function() {
        window.close();
    });
</script>
@yield('js')
</body>
</html>
