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
                            <a href="{{route('companies.view')}}"><i class="fas fa-building mr-3"></i>企業データの編集<i class="fas fa-angle-double-right"></i></a>
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
                            <a href="{{route('companies.delete.cancel')}}">アカウント削除申請を取り消す</a>
                        @else
                            <a href="{{route('companies.delete')}}">アカウント削除申請</a>
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