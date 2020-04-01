<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'JOB CiNEMA') }}</title>
    
    <!-- Scripts -->
    <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- <script src="{{ asset('js/main.js') }}" defer></script> -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    
    <script>
    $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
        });
    } );
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                     JOB CiNEMA 
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if(Auth::guard('employer')->check() == 0 && Auth::guard()->check() == 0)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('無料会員登録') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('employer.register.index') }}">{{ __('求人企業様のご登録') }}</a>
                            </li>
                        @else
        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if (Auth::guard('employer')->check())
                                    @if(!empty(Auth::guard('employer')->user()->company->cname))
                                        {{Auth::guard('employer')->user()->company->cname}} <span class="caret"></span>
                                    @else
                                        ゲストさん<span class="caret"></span>
                                    @endif
                                @endif
                                @if (Auth::guard()->check())
                                    @if(!empty(Auth::guard()->user()->last_name) || !empty(Auth::guard()->user()->first_name))
                                        {{Auth::guard()->user()->last_name}} {{Auth::guard()->user()->last_name}}さん<span class="caret"></span>
                                    @else
                                        ゲストさん<span class="caret"></span>
                                    @endif
                                @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (Auth::guard('employer')->check())
                                        <a class="dropdown-item" href="{{ route('job.create') }}">
                                            {{ __('求人票を作成') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('companies.view') }}">
                                            {{ __('企業ページ') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('my.job') }}">
                                            {{ __('掲載求人') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('applicants.view') }}">
                                            {{ __('応募者') }}
                                        </a>
                                    @endif
                                    @if(Auth::guard()->check())
                                        <a class="dropdown-item" href="{{ route('mypages.index') }}">
                                            {{ __('マイページ') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('keeplist') }}">
                                            {{ __('お気に入りリスト') }}
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('ログアウト') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
<script>
'use strict';
{

$(function(){
    $(".jobimg").on('change', function(){
        var fileprop = $(this).prop('files')[0],
            find_img = $(this).parent().next().find('img'),
            filereader = new FileReader(),
            mediaBody = $(this).parent('.media-body');
        
       if(find_img.length){
          find_img.nextAll().remove();
          find_img.remove();
       }
        
       var img = '<div class="img_view"><img alt="" class="img" style="width:100%;"><p><a href="#" class="img_del">画像を削除する</a></p></div>';
        
       mediaLeft = mediaBody.next();
       mediaLeft.append(img);
    
       filereader.onload = function() {
        mediaLeft.find('img').attr('src', filereader.result);
         img_del(mediaLeft);
       }
       filereader.readAsDataURL(fileprop);
     });
      
     function img_del(target){
       target.find("a.img_del").on('click',function(){
         var self = $(this),
             parentBox = self.parent().parent().parent();
         if(window.confirm('画像を削除します。\nよろしいですか？')){
           setTimeout(function(){
             parentBox.find('input[type=file]').val('');
             parentBox.find('.img_view').remove();
           } , 0);            
         }
         return false;
       });
     }  

}
</script>
</body>
</html>
