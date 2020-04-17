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
<link rel="stylesheet" href="{{ asset('css/popup/popup__style.css') }} ">
<!-- <link rel="stylesheet" href="{{ asset('css/popup/popup__qr.css') }} ">
<link rel="stylesheet" href="{{ asset('css/popup/popup__jobctgry.css') }} "> -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- js -->
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>

<script type="text/javascript" src="{{ asset('js/jc_functions.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('js/jc_ajax.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('js/jc_popup.js') }}"></script>


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