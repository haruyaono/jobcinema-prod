<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">求人カテゴリ</h1>
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
                <a href="{{route('admin_category', ['status'])}}">雇用形態カテゴリ</a>
            </p>
            <p>
                <a href="{{route('admin_category', ['type'])}}">職種カテゴリ</a>
            </p>
            <p>
                <a href="{{route('admin_category', ['area'])}}">エリアカテゴリ</a>
            </p>
            <p>
                <a href="{{route('admin_category', ['salary'])}}">給与カテゴリ</a>
            </p>
            <p>
                <a href="{{route('admin_category', ['date'])}}">勤務日数カテゴリ</a>
            </p>
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
<script>
    $(function() {
        $('a').click(function() {
            $(this).click(function () {
                alert('只今処理中です。\nそのままお待ちください。');
                return false;
            });
        });
    });
</script>
@stop