@extends('layouts.master')

@section('title', 'JOB CiNEMA')
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
    <a>
        無料新規会員登録
    </a>
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
<section class="main-section">
		<div class="inner">
			<div class="pad">
				<h2 class="txt-h2">無料新規会員登録</h2>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="register-complete-txt">無料会員登録が完了しました！</p>
                    <a class="top-redirect-btn" href="/">トップページに戻る</a>
                </div>
            </div>
        </div>
</section>

@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection
