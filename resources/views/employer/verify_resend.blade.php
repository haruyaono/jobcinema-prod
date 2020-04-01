@extends('layouts.employer_form_master')

@section('title', '本登録用メールの再送 | JOB CiNEMA')

@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.employer.form_header')
  @endcomponent
@endsection

@section('contents')
<div class="main-wrap">
  <section class="main-section emp-register-section">
		<div class="inner">
			<div class="pad">
            <h2 class="txt-h2 mb-5 text-center">本登録用メールの再送</h2>
            @if (count($errors) > 0)
                <div class="alert alert-danger col-md-6 mx-auto">
                    <strong><i class="fas fa-exclamation-circle"></i>エラー</strong><br>
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          <div class="mt-1">
            <form class="form-horizontal col-md-6 mx-auto p-0" role="form" method="POST" action="{{ url('/employer/verify/resend') }}">
                @csrf
    
                <div class="form-group">
                    <label class="control-label">メールアドレス</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </div>
    
                <div class="form-group ">
                    <div class="text-center mt-5">
                        <button type="submit" class="btn">
                        再送信
                        </button>
                    </div>
                </div>
            </form>
          </div>
        </div> 
        <ul class="emp-form-pagetop-list mb-1 mt-2">
            <li><i class="far fa-arrow-alt-circle-right mr-1"></i><a href="/">HOME</a></li>
            <li><i class="far fa-arrow-alt-circle-up mr-1"></i><a href="">ページトップへ</a></li>
        </ul>
    </div> 
  </section>
</div>
@endsection

@section('footer')
  @component('components.employer.form_footer')
  @endcomponent
@endsection