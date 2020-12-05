@extends('layouts.master')

@section('title', 'お祝い金申請')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.header')
@endcomponent
@endsection

@section('contents')
<div class="main-wrap">
  <section class="main-section">
    <div class="inner">
      <div class="pad">
        <h1 class="txt-h1 font24 font-weight-normal">お祝い金申請</h1>
        <p>採用の事実等がなくお祝い金を受け取られた場合、不正受給にあたり、返金に加え損害賠償を請求する場合がございます。<br>また、悪質な場合は刑事罰が科される場合がございます。</p>
        @if( Auth::guard('seeker')->check() )

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

        <table class="table table-bordered mt-4">
          <tr>
            <th>
              <span class="apply-job-table-heading-text">氏名</span>
            </th>
            <td>
              <div class="form-row m-0">
                {{ preg_replace("/( |　)/", "", Auth::guard('seeker')->user()->full_name ) != '' ? Auth::guard('seeker')->user()->full_name : 'ゲストさん' }}
              </div>
            </td>
          </tr>
        </table>
        <div class="form-group text-center mt-5">
          <a href="javascript:void(0)" class="btn btn-yellow w-50" onclick="submit('reward-application-form', event)">申請する</a>

          <form id="reward-application-form" action="{{ route('store.front.reward') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
        @else
        <div class="container">
          <p class="text-center h5 mt-5 mb-4">お祝い金申請にはログインが必要です</p>
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="card login-card">
                <div class="card-body login-card-body">
                  <form method="POST" action="{{ route('seeker.login') }}" aria-label="{{ __('Login') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI'] ?>">

                    <div class="form-group row">
                      <label for="email" class="col-12 col-md-4 col-form-label text-left text-md-right">{{ __('メールアドレス') }}</label>

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
                      <label for="password" class="col-12 col-md-4 col-form-label text-left text-md-right">{{ __('パスワード') }}</label>

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

                        <a class="forget-passlink" href="{{ route('seeker.password.request') }}">
                          {{ __('パスワードを忘れた方') }}
                        </a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </section>
</div> <!-- main-wrap-->
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection
