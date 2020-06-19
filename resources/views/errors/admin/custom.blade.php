<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">エラー</h1>
<span><a href="{{route('admin.home')}}" style="margin-left:10px;">Back</a></span>
  
    @if(Session::has('message'))
    <div class="alert alert-success" style="margin-top:15px;">{{Session::get('message')}}</div>
    @endif
@stop


<!-- ページの内容を入力 -->
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-body">
        <p>
          <i class="fas fa-exclamation-circle noteIcon"></i> 
          <em>
          @if($error_name === 'NotUser')
            該当する応募ユーザーが存在しません。
          @endif
          </em>
        </p>
        <p><a href="#" onclick="javascript:window.history.back(-1);return false;" class="txt-blue-link">戻る</a></p>
      </div>
  </div>
</div>

@stop

<!-- 読み込ませるCSSを入力 -->
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

<!-- 読み込ませるJSを入力 -->
@section('js')
  
@stop
