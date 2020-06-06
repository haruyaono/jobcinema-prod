@extends('layouts.employer_mypage_master')

@section('title', '企業ページ　| JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.employer.mypage_header')
  @endcomponent
@endsection

@section('contents')
<!-- パンくず -->
<div id="breadcrumb" class="e-mypage-bread only-pc">
<ol>
  <li>
  <span class="bread-text-color-red">企業ページ</span>
  </li>
</ol>
</div>

<!-- INC TOP 001 MODAL 001 -->
<!-- <div class="jsc-modal-overlay modal-overlay"></div>

<div id="popupArea" class="jsc-modal-box modal-box modalBoxBorder">
    <style>
        .modal-overlay{
            position: fixed;
            top: 0;
            left: 0;
            display: none;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .8);
            opacity: 0;
            transition: all .3s linear;
        }

        .modal-overlay.isVisible {
            opacity: 1;
            cursor: pointer;
            z-index: 2;
        }

        .modal-box {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
            margin: auto;
            padding: 50px 0;
            width: 50%;
            min-width: 560px;
            max-width: 760px;
            height: 30%;
            min-height: 150px;
            max-height: 300px;
            text-align: center;
            background: #fff;
            border: solid 2px #C93A3F;
            border-radius: 10px;
            opacity: 0;
            transition: all .3s linear;
            cursor: default;
        }
        .modal-box.isVisible {
            opacity: 1;
            z-index: 2;
        }

        #popupArea{
            max-width: 600px;
            min-height:300px;
            padding:0;
            border: 5px solid #DE960F;
            border-radius: 5px;     
        }
       
    
        #inc_top_001_modal_001{
            margin-top: 36px;
        }
        #inc_top_001_modal_001>.desc{
            display: inline-block;
            margin:0 auto;
            padding-top:5%;
        }
        #inc_top_001_modal_001>img{
            display: inline-block;
            vertical-align: top;
            margin:38px 33px 0 0;
        }
        #inc_top_001_modal_001>.desc {
            display: inline-block;
            margin: 0 auto;
            padding-top: 5%;
        }
        #inc_top_001_modal_001 h2 {
            font-size: 20px;
        }
        #inc_top_001_modal_001 p{
            margin-top :10px;
            font-size:14px;
        }
        #inc_top_001_modal_001+nav{
            margin-top: 33px;
        }
        .modal-box nav .button, .k_modalDvrsn nav .button {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            position: relative;
            display: inline-block;
            padding: 15px 20px;
            min-width: 80%;
            color: #DE960F;
            text-align: center;
            text-decoration: none !important;
            font-size: 21px;
            font-weight: bold;
            line-height: 1.3;
            background: #fff;
            border-radius: 10px;
            border: solid 1px #DE960F;
            -webkit-box-shadow: 1px 1px 5px rgba(0, 0, 0, .4);
            box-shadow: 1px 1px 5px rgba(0, 0, 0, .4);
        }
        #inc_top_001_modal_001+nav .button{
            min-width:250px;
            height:60px;
            vertical-align: top;
            margin-bottom:10px;
            font-size:16px;
            line-height: 1.5;
        }
        
        #inc_top_001_modal_001+nav .primary{
            padding-top:7px;
            color: #fff;
            background: #DE960F;
        }
        #popupArea .popupJoCrt {
            font-size: 18px;
            min-width: auto;
            width: 40%;
            vertical-align: top;
        }
        #popupArea .popupGuideFirstUse {
            font-size: 18px;
            min-width: auto;
            width: 40%;
            color: #DE960F;
            padding: 23px 20px;
        }
        #inc_top_001_modal_001+nav .popupGuideFirstUse{
            padding-top: 15px;
        }
        .close-label {
            position: absolute;
            top: -30px;
            right: 10px;
            display: inline-block;
            width: 30px;
            height: 30px;
            color: #fff;
            font-size: 28px;
            text-align: center;
            line-height: 30px;
            background: #e3e3e3;
            cursor: pointer;
        }
        #inc_top_001_modal_001~.close-label{
            top:0px;
            right:0px;
            width:40px;
            height: 40px;
            font-size:35px;
            line-height: 40px;
        }
    </style>
    <style>
        @media screen and (min-width: 1px) and (max-width: 520px) {
            #inc_top_001_modal_001{
                margin-top: 0px;
            }
            #popupArea{
                padding-top: 0;
            }
            #inc_top_001_ {
                text-align: center;
            }
            #inc_top_001_modal_001 img {
                width:16%;
                height:auto;
                margin: 30px -12px 0 0;
            }
            #inc_top_001_modal_001 h2 {
                margin-top: 20px;
                font-size: 16px;
            }
            #inc_top_001_modal_001 p{
                margin-top: 12px;
                font-size:12px;
            }
            #inc_top_001_modal_001+nav .button{
                margin-bottom:10px;
            }
        }
    </style> -->
    <!-- <div id="inc_top_001_modal_001">
        <div class="desc">
            <h2>JOB CiNEMAへの<br>
                ご登録ありがとうございます
            </h2>
            <p>求人原稿を作成し、掲載を開始しましょう！</p>
        </div>
    </div> -->
    <!-- //INC TOP 001 MODAL 001 --> 
    <!-- <nav>
        <a href="/jobs/create/step1" class="button primary popupJoCrt">
            さっそく原稿をつくる
        </a>
    </nav>
    <div class="jsc-close-label close-label">×</div>
</div> -->

<div class="main-wrap">
    <section class="main-section">
        <div class="inner">
            <div class="pad">
                @if(Auth::guard('employer')->user()->status == 8)
                <div class="border border-danger p-3 mb-5">
                    <p class="text-danger h3 mb-3">アカウント削除申請中</p>
                    「アカウント削除申請を取り消す」から解除できます。
                </div>
                @endif

                @if (Session::has('message_success'))
                <div class="alert alert-success mt-3">
                {!! nl2br(htmlspecialchars(Session::get('message_success'))) !!}
                </div>
                @endif
                @if (Auth::guard('employer')->check())
                    @if(!empty(Auth::guard('employer')->user()->company->cname))
                    <p class="h3">{{Auth::guard('employer')->user()->company->cname}}様の管理ページ<span class="caret"></span></p>
                    @else
                    <p class="h3">ゲスト様の管理ページ<span class="caret"></span></p>
                    @endif
                @endif
                
                <div class="row justify-content-center mt-4">
                    <div class="col-md-8 e-mypage-card">
                        <div class="e-mypage-card-item">
                            <a href="{{route('job.create.top')}}"><i class="fas fa-edit mr-3"></i>求人票を作成<i class="fas fa-angle-double-right"></i></a>
                        </div>
                        <div class="e-mypage-card-item">
                            <a href="{{route('my.job')}}"><i class="fas fa-edit mr-3"></i>求人票の一覧<i class="fas fa-angle-double-right"></i></a>
                        </div>
                        <div class="e-mypage-card-item">
                            <a href="{{route('applicants.view')}}"><i class="fas fa-address-card mr-3"></i>応募者を見る<i class="fas fa-angle-double-right"></i></a>
                        </div>
                        <div class="e-mypage-card-item">
                            <a href="{{route('companies.edit')}}"><i class="fas fa-building mr-3"></i>企業データの編集<i class="fas fa-angle-double-right"></i></a>
                        </div>
                        <div class="e-mypage-card-item">
                            <a href="{{route('employer.changeemail.get')}}"><i class="fas fa-envelope mr-3"></i>メールアドレス変更<i class="fas fa-angle-double-right"></i></a>
                        </div>
                        <div class="e-mypage-card-item">
                            <a href="{{route('employer.changepassword.get')}}"><i class="fas fa-key mr-3"></i>パスワード変更<i class="fas fa-angle-double-right"></i></a>
                        </div>
                        <div class="e-mypage-card-item">
                            <a href="{{ route('employer.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt mr-3"></i>ログアウト</a>
                        </div>
                        <form id="logout-form" action="{{ route('employer.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                    <div class="col-md-4 e-mypage-card">
                        <div class="e-mypage-right-item">
                            <a href="/terms_service_e" target="_blank">利用規約<i class="far fa-arrow-alt-circle-right"></i></a>
                        </div>
                        <!-- <div class="e-mypage-right-item">
                            <a href="">注意事項<i class="far fa-arrow-alt-circle-right"></i></a>
                        </div> -->
                        <div class="mt-4 text-center">
                        @if(Auth::guard('employer')->user()->status == 8)
                            <a href="{{route('companies.delete.cancel')}}" class="txt-blue-link">アカウント削除申請を取り消す</a>
                        @else
                            <a href="{{route('companies.delete')}}" class="txt-blue-link">アカウント削除申請</a>
                        @endif
                            
                        </div>

                    </div>
                    
                    
                </div><!-- row -->
            </div>  <!-- pad -->
        </div>  <!-- inner --> 
    </section>
</div> <!-- main-wrap -->
@endsection

@section('footer')
  @component('components.employer.mypage_footer')
  @endcomponent
@endsection


@section('js')
<!-- <script> -->
<!--
    // function mypageModal() {
    //         var overlayElem		= $('.jsc-modal-overlay'),
    //             closeElem		= $('.jsc-modal-overlay, .jsc-close-label'),
    //             modalElem		= $('.jsc-modal-box');

    //         overlayElem.css('display','block').addClass('isVisible');
    //         modalElem.css('display','block').addClass('isVisible');
    //         closeElem.on('click', function() {
    //             overlayElem.removeClass('isVisible');
    //             modalElem.removeClass('isVisible');
    //             setTimeout(function() {
    //                 overlayElem.css('display','none');
    //                 modalElem.css('display','none');
    //             }, 300);
    //         });
    // }
    // $(function() {

    //     if( !sessionStorage.getItem('disp_popup') ) {
    //         sessionStorage.setItem('disp_popup', 'on');
            
    //         setTimeout(function() {mypageModal();}, 500);
    //     }
    // });

//-->
<!-- </script> -->
@endsection

