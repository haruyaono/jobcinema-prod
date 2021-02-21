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
            <li>
                <a href="{{ route('seeker.index.notice') }}">お知らせ</a>
            </li>
            <li>
                詳細
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
    @component('components.footer')
    @endcomponent
@endsection
