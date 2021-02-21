@extends('layouts.employer_mypage_master')

@section('title', 'お知らせ一覧 | JOB CiNEMA')
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
                <a href="{{ route('enterprise.index.mypage') }}"><span class="bread-text-color-blue">企業ページ</span></a>
            </li>
            <li>
                <span class="bread-text-color-red">お知らせの確認</span>
            </li>
        </ol>
    </div>
    <div class="main-wrap">
        <section class="main-section">
            <div class="inner">
                <div class="pad">
                    <div class="row w-100 m-0  justify-content-center">
                        <div class="col-12 px-0">
                            @if(Session::has('message_alert'))
                                <div class="alert alert-danger">
                                    {{ Session::get('message_alert') }}
                                </div>
                            @endif
                            @if(Session::has('message_success'))
                                <div class="alert alert-success">
                                    {{ Session::get('message_success') }}
                                </div>
                            @endif

                            <div class="sectionItemTtl">
                                <p>お知らせ</p>
                            </div>
                            <div class="sectionItem">
                                @if($notices->count() > 0)
                                    @foreach($notices as $notice)
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="floatL" href="{{ route('enterprise.show.notice', ['notice' => $notice->id]) }}">{{ $notice->subject }}</a>
                                                <div class="floatR alignright">未読</div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-center mt-3">お知らせはありません。</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <a class="btn back-btn" href="#" onclick="javascript:window.history.back(-1);return false;"><i class="fas fa-reply mr-3"></i>前に戻る</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @component('components.employer.mypage_footer')
    @endcomponent
@endsection