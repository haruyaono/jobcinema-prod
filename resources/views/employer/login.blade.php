@extends('layouts.employer_form_master')

@section('title', '企業用ログイン | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.employer.form_header')
  @endcomponent
@endsection

@section('contents')
<!-- パンくず -->
<div id="breadcrumb" class="bread only-pc">
<ol>
  <li>
    <a href="/">
      <i class="fa fa-home"></i><span>TOP</span>
    </a>
  </li>
  <li>
        企業用ログイン
  </li>
</ol>
</div>

<div class="main-wrap">
    <section class="main-section emp-login-section">
		<div class="inner">
			<div class="pad">
            <h2 class="txt-h2">企業用ログイン</h2>
        @if (Session::has('flash_message_danger'))
            <div class="alert alert-danger mt-3">
            {!! nl2br(htmlspecialchars(Session::get('flash_message_danger'))) !!}
            </div>
        @endif
        @if (Session::has('flash_message_success'))
            <div class="alert alert-success mt-3">
            {!! nl2br(htmlspecialchars(Session::get('flash_message_success'))) !!}
            </div>
        @endif
<div class="container px-0">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card login-card">

                <div class="card-body login-card-body">
                    <form method="POST" action="{{route('employer.login.post')}}" aria-label="{{ __('Login') }}">
                    {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email" class="col-md-12 text-left"><i class="fas fa-envelope mr-1"></i>{{ __('メールアドレス') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-12 text-left"><i class="fas fa-unlock-alt mr-1"></i>{{ __('パスワード') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
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
                    </form>
                </div>
            </div>

            <ul class="emp-login-link">
                <li>
                    <a href="{{route('employer.register.index')}}">新規企業のご登録はこちら</a>
                </li>
                <li>
                    <a class="forget-passlink" href="{{ route('employer.password.request') }}">
                        {{ __('パスワードを忘れた方はこちら(再発行)') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

</div>
</div>  
</section>
</div>
@endsection

@section('footer')
  @component('components.employer.form_footer')
  @endcomponent
@endsection