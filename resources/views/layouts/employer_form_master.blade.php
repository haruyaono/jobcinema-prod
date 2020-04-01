<!DOCTYPE html>
<html lang="ja">
<head>
  <title>@isset ($title) {{$title}} | @endisset @yield('title')</title>
  <script defer src="{{ asset('js/app.js') }}"  ></script>
  
  @include('../partials.head')
</head>
<body>
    <div class="wrap e-wrap" id="app">
        <div class="contents">
            
            @yield('header')
            @yield('contents')
            @yield('footer')
        </div>
    </div> 

</body>
</html>
