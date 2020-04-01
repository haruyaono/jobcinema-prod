@extends('layouts.employer_master')

@section('title', '本登録が終わっていません | JOB CiNEMA')

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
          <div class="d-flex">
            <h2 class="txt-h2">本登録を完了してください。</h2>
          </div> 
          <p class="mt-２ mb-4">現在、企業様専用ページにログイン中ですが、全ての操作に制限をかけております。</p>
          @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('新しい本登録用リンクがメールアドレスに送信されました。') }}
                </div>
            @endif
          <div class="col-md-12mt-1 emp-register-endfield">
            <div>求人票作成などの操作を行うには、本登録が必要です。<br>登録済みメールアドレスに送られたリンクを確認しましょう。</div>

            <!-- <p>※もしメールが届いていない場合は、<a href="{{ route('verification.resend') }}">ここをクリック</a>してください。<span></span></p> -->
          </div>

          <div class="text-center my-5"><a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('ログアウト') }}
                                    </a></div>
        </div> 
        <ul class="emp-form-pagetop-list mb-1 mt-2">
            <li><i class="far fa-arrow-alt-circle-right mr-1"></i><a href="/">HOME</a></li>
        </ul>
    </div> 
  </section>
</div>

@endsection

@section('footer')
  @component('components.employer.form_footer')
  @endcomponent
@endsection
