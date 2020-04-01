@extends('layouts.master')

@section('title', 'パスワード変更 | JOB CiNEMA')
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
    <a href="/mypage/index">
     　マイページ
    </a>
  </li>
  <li>
  パスワード変更
  </li>
</ol>
</div>
<div class="main-wrap">
<section class="main-section">
<div class="inner">
<div class="pad">
    <h2 class="txt-h2 mb-3">パスワード変更</h2>
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
          <form method="POST" action="{{route('mypage.changepassword.post')}}">
            @csrf
            <div class="form-group text-left d-sm-flex justify-content-center">
              <label for="current" class="col-md-3 col-sm-4 col-12 px-0">
                現在のパスワード
              </label>
            <input id="current" type="password" class="form-control col-lg-3 col-md-3 col-sm-4 col-10" name="current-password" required autofocus>
            </div>
            <div class="form-group text-left d-sm-flex justify-content-center">
              <label for="password" class="col-lg-3 col-md-3 col-sm-4 col-12 px-0">
                新しいパスワード
              </label>
                <input id="password" type="password" class="form-control col-lg-3 col-md-3 col-sm-4 col-10" name="new-password" required>

            </div>
            <div class="form-group text-left d-sm-flex justify-content-center">
              <label for="confirm" class="col-md-3 col-sm-4 col-12 px-0">
                新しいパスワード（確認用）
              </label>
            <input id="confirm" type="password" class="form-control col-lg-3 col-md-3 col-sm-4 col-10" name="new-password_confirmation" required>
            </div>
            <div class="mt-4">
              <button type="submit" class="btn">更新</button>
            </div>
          </form>
        </div>


                

<p class="mt-5"><i class="fas fa-arrow-left mr-1"></i><a href="/mypage/index">前に戻る</a></p>

</div>
</div>  
</section>
</div>
@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection
