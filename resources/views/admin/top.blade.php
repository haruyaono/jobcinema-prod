<!-- adminlte::pageを継承 -->
@extends('adminlte::page')
<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1><i class="fas fa-home mr-2"></i>ダッシュボード</h1>
@stop

<!-- ページの内容を入力 -->
@section('content')
<p>JOBCiNEMA専用の管理画面です</p>
@stop

<!-- 読み込ませるCSSを入力 -->
<!-- @section('css')
@stop -->

<!-- 読み込ませるJSを入力 -->
@section('js')

@stop
