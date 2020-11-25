@extends('layouts.employer_mypage_master')

@section('title', 'パスワード変更 | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.employer.mypage_header')
@endcomponent
@endsection

@section('contents')
<div id="breadcrumb" class="e-mypage-bread only-pc">
  <ol>
    <li>
      <a href="{{ route('enterprise.index.mypage') }}"><span class="bread-text-color-blue">企業ページ</span></a>
    </li>
    <li>
      <span class="bread-text-color-red">パスワード変更</span>
    </li>
  </ol>
</div>

<div class="main-wrap">
  <section class="main-section">
    <div class="inner">
      <div class="pad">
        <h2 class="h3 mb-3">パスワード変更</h2>
        @if(count($errors) > 0)
        <div class="alert alert-danger">
          <ul class="list-unstyled">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        @if (session('change_password_error'))
        <div class="container mt-2">
          <div class="alert alert-danger">
            {{session('change_password_error')}}
          </div>
        </div>
        @endif

        @if (session('change_password_success'))
        <div class="container mt-2">
          <div class="alert alert-success">
            {{session('change_password_success')}}
          </div>
        </div>
        @endif

        <div class="card-body mypage-card">
          <form method="POST" action="{{ route('enterprise.changepassword.post') }}">
            @csrf
            <div class="form-group text-left d-flex justify-content-center">
              <label for="current" class="w-25">
                現在のパスワード
              </label>
              <input id="current" type="password" class="form-control w-25" name="current-password" required autofocus>
            </div>
            <div class="form-group text-left d-flex justify-content-center">
              <label for="password" class="w-25">
                新しいパスワード
              </label>
              <input id="password" type="password" class="form-control w-25" name="new-password" required>

            </div>
            <div class="form-group text-left d-flex justify-content-center">
              <label for="confirm" class="w-25">
                新しいパスワード（確認用）
              </label>
              <input id="confirm" type="password" class="form-control w-25" name="new-password_confirmation" required>
            </div>
            <div class="mt-5">
              <button type="submit" class="btn">更新</button>
            </div>
          </form>
        </div>



        <div class="text-center mt-5">
          <a class="btn back-btn" href="{{ route('enterprise.index.mypage') }"><i class="fas fa-reply mr-3"></i>前に戻る</a>
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
