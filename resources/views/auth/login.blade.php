@extends('layouts.master')

@section('title', 'ログイン | JOB CiNEMA')
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
            求職者ログイン
        </li>
    </ol>
</div>

<div class="main-wrap">
    <section class="main-section newjob-entry">
        <div class="inner">
            <div class="pad">
                <h2 class="txt-h2"><i class="fas fa-user font-yellow mr-2"></i>求職者ログイン</h2>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-12 col-md-10 col-lg-8">
                            <div class="card login-card">
                                <div class="card-body login-card-body">
                                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                                        {{ csrf_field() }}

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-sm-12 col-form-label text-left text-md-right text-sm-left">{{ __('メールアドレス') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-left text-md-right text-sm-left">{{ __('パスワード') }}</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                                @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="forget-passlink-wrap" style="text-align:right">
                                            <a class="forget-passlink" href="{{ route('password.request') }}">
                                                {{ __('パスワードを忘れた方') }}
                                            </a>
                                        </div>


                                        <div class="form-group row">
                                            <div class="col-md-6 offset-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="remember">
                                                        {{ __('次回から自動ログインする') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-3">
                                                <button type="submit" class="btn">
                                                    {{ __('ログイン') }}
                                                </button>
                                            </div>
                                        </div>

                                        <p class="text-center mt-4"><a href="{{route('register')}}" class="txt-blue-link">無料会員登録はこちら</a></p>
                                    </form>
                                </div>
                            </div>

                            <div class="c-login-link-in-user-login">
                                <a href="{{url('/employer/login')}}"><i class="fas fa-building d-block"></i>企業用ログインはこちら</a>
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
