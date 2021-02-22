@extends('layouts.master')

@section('title', 'お知らせ | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
    @component('components.header')
    @endcomponent
@endsection

@section('contents')
    <!-- パンくず -->
    <div id="breadcrumb" class="bread only-pc">
        <ol>
            <li>
                <a href="{{ route('seeker.index.mypage') }}">マイページ</a>
            </li>
            <li>お知らせ</li>
        </ol>
    </div>

    <div class="main-wrap">
        <section class="main-section">
            <div class="inner">
                <div class="pad">
                    @if (Session::has('flash_message_success'))
                        <div class="alert alert-success mt-3">
                            {!! nl2br(htmlspecialchars(Session::get('flash_message_success'))) !!}
                        </div>
                    @endif
                    @if (Session::has('flash_message_danger'))
                        <div class="alert alert-danger mt-3">
                            {!! nl2br(htmlspecialchars(Session::get('flash_message_danger'))) !!}
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
                                        <a class="floatL" href="{{ route('seeker.show.notice', ['notice' => $notice->id]) }}">{{ $notice->subject }}</a>
                                        @if(!$nrs->isReadUser($uid, $notice->id))
                                            <div class="floatR alignright">未読</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center mt-3">お知らせはありません。</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('footer')
    @component('components.footer')
    @endcomponent
@endsection
