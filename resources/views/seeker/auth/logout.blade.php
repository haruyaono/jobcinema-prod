@extends('layouts.master')

@section('title', 'ログアウト | JOB CiNEMA')
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
        ログアウト
    </a>
  </li>
</ol>
</div>

<section class="main-section">
		<div class="inner">
			<div class="pad">
				<h2 class="txt-h2">ログアウト</h2>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="register-complete-txt">ログアウトしました。</p>
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
