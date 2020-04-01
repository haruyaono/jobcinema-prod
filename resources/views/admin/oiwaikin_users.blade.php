<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">お祝い金申請ユーザー</h1>
<span><a href="/dashboard/home" style="margin-left:10px;">Back</a></span>
  
    @if(Session::has('message'))
    <div class="alert alert-success" style="margin-top:15px;">{{Session::get('message')}}</div>
    @endif
@stop

<!-- ページの内容を入力 -->
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-body">

        @if(!$oiwaikin_users->isEmpty())

        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">ユーザーID</th>
            <th>名前</th>
            <th scope="col">初出社日</th>
            <th>お祝い金申請</th>
            <th scope="col">採用結果</th>
            <th scope="col">応募先</th>
            </tr>
        </thead>
        <tbody>
            @foreach($oiwaikin_users as $oiwaikin_user)

            <tr>
            <td>{{ $oiwaikin_user->user_id}}</td>
            <td><a href="{{route('user.detail.get', [$oiwaikin_user->id])}}">{{ $oiwaikin_user->last_name}} {{ $oiwaikin_user->first_name}}</a></td>
            <td>{{ $oiwaikin_user->first_attendance}}</td>
            <td>あり {{ $oiwaikin_user->oiwaikin}}円</td>
            <td>{{config("const.JOB_STATUS.{$oiwaikin_user->e_status}", "未定義")}}</td>
            <td><a href="{{route('admin.job.detail',[$oiwaikin_user->job_item_id])}}" target="_blank">見る</a></td>
            </tr>
            @endforeach

        </tbody>
        </table>

        @else
        <p>データがありません</p>
        @endif

        {{$oiwaikin_users->links()}}
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