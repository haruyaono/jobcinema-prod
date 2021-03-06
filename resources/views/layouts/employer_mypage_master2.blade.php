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

<script defer src="{{ asset('js/app.js') }}"></script>
<!-- <script defer src="{{ asset('js/main.js') }}"></script> -->

<script>

    $('.emp-header-right #navbarDropdown').click(function() {
        $('.emp-header-right .dropdown-menu').slideToggle();
        return false;
    });

    });
</script>
</body>
</html>
