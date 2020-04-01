@extends('layouts.employer_form_master')

@section('title', '本登録完了 | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
component('components.employer.form_header')
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
    本登録完了
  </li>
</ol>
</div>
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    無料会員登録が完了しました！
                    <a href="/">トップページに戻る</a>
                </div>
            </div>
        </div>
    </div>
</div> -->
<section class="newjob-entry register-entry">
		<div class="inner">
			<div class="pad">
				<h2 class="txt-h2">本登録が完了しました。</h2>
                <div class="card-body">
                    <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif -->

                    <p class="register-complete-txt">引き続き、求人票作成などの操作を行えます。</p>
                    <a class="top-redirect-btn" href="/">HOMEに戻る</a>
                </div>
            </div>
        </div>
</section>

@endsection

@section('footer')
@component('components.employer.form_footer')
  @endcomponent
@endsection
