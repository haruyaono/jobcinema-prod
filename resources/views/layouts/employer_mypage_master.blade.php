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
<input type="hidden" id="env_name" name="env_name" value="{{config('app.env')}}">
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
$(function() {

    $('#close_button').click(function() {
        window.close();
    });
    
    if($('#env_name').length) {
        var env_name = $('#env_name').attr('value');
        if(env_name == 'local') {
            var base_image_url = 'https://s3.job-cinema.com';
        } 
    } else {
        var env_name = '';
    }


    
});
    

</script>
@yield('js')
</body>
</html>
