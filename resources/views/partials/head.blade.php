<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="description" content="@yield('description')"> 
<!-- css -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }} ">
<link rel="stylesheet" href="{{ asset('css/styles.css') }} ">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!------ js ------>
<!-- jquery -->
<script src="{{ asset('js/jquery-3.5.0.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
<!-- vue -->
<!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script> -->
@if(config('app.env') === 'production')
<script type="text/javascript" src="{{ asset('js/vue.min.js') }}"></script>
@else
<script type="text/javascript" src="{{ asset('js/vue.js') }}"></script>
@endif
<!-- jquery-ui -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>

<!-- slick -->
<!-- <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script> -->

<script type="text/javascript" src="{{ asset('js/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common.js') }}"></script>



<script>
  $(function() {
   
    $(".tab_label").on("click",function(){
            var $th = $(this).index();
            $(".tab_label").removeClass("active");
            $(".tab_panel").removeClass("active");
            $(this).addClass("active");
            $(".tab_panel").eq($th).addClass("active");
        });
  });
</script>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
 
<link rel="icon" type="image/png" href="{{asset('/uploads/images/job_cinema_fav.png')}}" sizes="32x32">