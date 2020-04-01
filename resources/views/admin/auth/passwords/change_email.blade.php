@extends('layouts.master')

@section('title', 'メールアドレス変更 | JOB CiNEMA')
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
  メールアドレス変更
  </li>
</ol>
</div>
<div class="main-wrap">
<section class="main-section">
<div class="inner">
<div class="pad">
    <h2 class="txt-h2 mb-3">メールアドレス変更</h2>
    @if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul class="list-unstyled">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session('change_email_error'))
        <div class="container mt-2">
            <div class="alert alert-danger">
            {{session('change_email_error')}}
            </div>
        </div>
    @endif

    @if (session('change_email_success'))
        <div class="container mt-2">
            <div class="alert alert-success">
                {{session('change_email_success')}}
            </div>
        </div>
    @endif

        <div class="card-body mypage-card">
          <form method="POST" action="{{route('mypage.changeemail.post')}}">
            @csrf
            <div class="form-group text-left d-flex justify-content-center">
              <label for="current" class="w-25">
                現在のメールアドレス
              </label>
              <div class="w-25">{{Auth::user()->email}}</div>
            </div>
            <div class="form-group text-left d-flex justify-content-center">
              <label for="password" class="w-25">
                新しいメールアドレス
              </label>
                <input id="email" type="email" class="form-control w-25" name="email" required>
            </div>
            <div class="mt-5">
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
