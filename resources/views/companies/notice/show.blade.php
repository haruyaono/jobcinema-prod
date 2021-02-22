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
                <a href="{{ route('enterprise.index.notice') }}"><span class="bread-text-color-blue">お知らせの確認</span>></a>
            </li>
            <li>
                <span class="bread-text-color-red">詳細</span>
            </li>
        </ol>
    </div>
    <div class="main-wrap">
        <section class="main-section">
            <div class="inner">
                <div class="pad">
                    <div class="row w-100 justify-content-center">
                        <h1 style="font-size: 2em">{{ $notice->subject }}</h1>
                    </div>
                    <div class="row w-100 justify-content-center" style="margin-top: 50px">
                        <p style="white-space: pre-wrap;">{{ $notice->content }}</p>
                    </div>
                    <div class="row w-100 justify-content-end" style="margin-top: 50px">
                        <p>更新日時: {{ $notice->updated_at }}</p>
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