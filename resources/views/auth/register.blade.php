@extends('layouts.master')

@section('title', '新規会員登録　| JOB CiNEMA')
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
        無料新規会員登録
  </li>
</ol>
</div>
<div class="main-wrap">
    <section class="main-section newjob-entry">
		<div class="inner">
			<div class="pad">
            <h2 class="txt-h2">無料新規会員登録</h2>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-10 col-lg-8">
                <div class="card register-card">

                    <div class="card-body register-card-body">
                        <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-left text-md-right text-sm-left">{{ __('メールアドレス') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

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

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-left text-md-right text-sm-left">{{ __('確認用パスワード') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <p><a href="/terms_service">利用規約</a>に同意のうえ、ご登録してください。</p>
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="btn">
                                        {{ __('会員登録する') }}
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
</div>  
</section>
</div>
@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection
