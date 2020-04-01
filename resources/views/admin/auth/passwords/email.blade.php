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
    <a href="{{route('login')}}">
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
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
        <div class="col-md-8">
            <div class="card login-card">

                <div class="card-body login-card-body">
                    

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <p class="h5 mb-4">ご登録のメールアドレスにパスワード再設定リンクをお送りします。</p>
                        <p>パスワードを再設定すると新しいパスワードになります。</p>
                        <p>ログイン後のマイページよりお好きなパスワードに変更することができます。</p>

                        <div class="form-group row my-4">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0 text-center">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('パスワードを通知') }}
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
