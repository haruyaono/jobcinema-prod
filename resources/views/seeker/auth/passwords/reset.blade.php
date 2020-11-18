@extends('layouts.master')

@section('title', 'パスワードの再発行 | JOB CiNEMA')
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
            <a href="/">
                <i class="fa fa-home"></i><span>釧路の求人情報TOP</span>
            </a>
        </li>
        <li>
            <a href="{{ route('seeker.login') }}">
                ログイン
            </a>
        </li>
        <li>
            パスワードの再発行
        </li>
    </ol>
</div>

<div class="main-wrap">
    <section class="main-section newjob-entry">
        <div class="inner">
            <div class="pad">
                <h2 class="txt-h2">パスワードの再発行</h2>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card login-card">
                            <div class="card-body login-card-body">
                                <form method="POST" action="{{ route('seeker.password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('確認用パスワード') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0 mt-4">
                                        <div class="col-md-6 offset-md-3">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('パスワードをリセット') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
