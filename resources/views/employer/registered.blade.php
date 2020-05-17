@extends('layouts.employer_form_master')

@section('title', '会社情報登録の完了 | JOB CiNEMA')

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
          <div class="d-flex d-no-flex">
            <h2 class="txt-h2">求人企業様のご登録</h2>
            <div class="emp-register-flow text-center d-inline-block">入力画面 -> 確認画面 -> <span class="emp-register-label bg-danger">仮登録完了</span></div>
          </div> 
          <p class="mt-0 mb-4">仮登録が完了しました。誠にありがとうございます。</p>
          <div class="col-md-12mt-1 emp-register-endfield">
              <div class="emp-register-yet"><i class="fas fa-exclamation-circle mr-2"></i>本登録はまだ終わっていません<i class="fas fa-exclamation-circle ml-2 i-only-pc"></i></div>
              <p class="font-bold">ご登録されたメールアドレスにメールを送りました。<br>そちらのメールから、会員登録を完了させてください。</p>
              
              <p>ご登録後、【求人票の作成】が行えます。</p>
          </div>
          <div class="text-center mt-5">
              <p class="text-danger">※もし仮登録完了メールが届かない場合は下記から再送してください</p>
              <a class="txt-blue-link" href="{{ url('/employer/verify/resend') }}">本登録用メールを再送する</a>
          </div>

          <div class="text-center my-5 only-pc txt-blue-link"><a href="{{route('employer.login')}}">ログインページ</a></div>
          <div class="text-center my-4 only-sp txt-blue-link"><a href="{{route('employer.login')}}">ログインページ</a></div>
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