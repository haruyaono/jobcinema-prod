@extends('layouts.master')

@section('title', '現在の状況・希望編集 | JOB CiNEMA')
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
            <a href="{{ route('seeker.index.mypage') }}">
                マイページ
            </a>
        </li>
        <li>
            現在の状況・希望編集
        </li>
    </ol>
</div>

<section class="main-section">
    <div class="inner">
        <div class="pad">
            <h2 class="txt-h2 mb-3">現在の状況・希望編集</h2>
            @if(Session::has('message'))
            <div class="alert alert-success">
                {{ Session::get('message') }}
            </div>
            @endif
            @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="container mypage-container px-1">
                <div class="row justify-content-around w-100 m-0">
                    <div class="col-12 mt-3 px-0">
                        <div class="card mypage-card">
                            <div class="card-header">現在の状況・希望編集</div>

                            <form action="{{ route('seeker.update.career') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body text-left">
                                    <div class="form-group">
                                        <label for="">現在の職業</label>
                                        <select name="data[profile][occupation]">
                                            <option value="0">-----</option>
                                            @foreach(config('const.OCCUPATION') as $occupation)
                                            <option value="{{ $occupation }}" @if(old('data.profile.occupation')==$occupation){{'selected'}}@elseif(!old('data.profile.occupation') && $profile->occupation == $occupation ){{ 'selected' }}@endif>{{ $occupation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">最終学歴</label>
                                        <select name="data[profile][final_education]">
                                            <option value="0">-----</option>
                                            @foreach(config('const.FINAL＿EDUCATION') as $education)
                                            <option value="{{ $education }}" @if(old('data.profile.final_education')==$education ){{'selected'}}@elseif(!old('data.profile.final_education') && $profile->final_education == $education ){{ 'selected' }}@endif>{{ $education }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <p>勤務開始可能日</p>
                                        <input id="allways" checked="checked" type="radio" name="data[profile][work_start_date]" value="いつでも可能" @if( old('data.profile.work_start_date')=='いつでも可能' ){{'checked'}}@elseif(!old('data.profile.work_start_date') && $profile->work_start_date == 'いつでも可能' ){{ 'checked' }}@endif>
                                        <label for="allways">いつでも可能</label>
                                        <input id="consultation" type="radio" name="data[profile][work_start_date]" value="面接時に相談" @if( old('data.profile.work_start_date')=='面接時に相談' ){{'checked'}}@elseif(!old('data.profile.work_start_date') && $profile->work_start_date == '面接時に相談' ){{ 'checked' }}@endif>
                                        <label for="consultation">面接時に相談</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="text-center">
                                            <button class="btn mt-3" type="submit">更新</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <p class="mt-5"><i class="fas fa-arrow-left mr-1"></i><a href="{{ route('seeker.index.mypage') }}" class="txt-blue-link">前に戻る</a></p>

        </div>
    </div>
</section>
</div>
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection
