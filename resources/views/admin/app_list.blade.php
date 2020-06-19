<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">応募管理</h1>
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

        @if(!$app_list->isEmpty())

        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">ユーザーID</th>
            <th>名前</th>
            <th scope="col">報告</th>
            <th scope="col">採用結果</th>
            <th scope="col">応募先</th>
            </tr>
        </thead>
        <tbody>
            @foreach($app_list as $app_item)

            <tr>
            <td>{{ $app_item->user_id}}
                @if(!App\Job\Users\User::where('id',$app_item->user_id)->exists())
                (削除済み)
                @endif
            </td>
            <td><a href="{{route('user.detail.get', [$app_item->apply_id])}}">{{ $app_item->last_name}} {{ $app_item->first_name}}</a></td>
            <td>{{config("const.JOB_STATUS.{$app_item->s_status}", "未定義")}}</td>
            <td>{{config("const.JOB_STATUS.{$app_item->e_status}", "未定義")}}</td>
            <td><a href="{{route('admin.job.detail',[$app_item->job_item_id])}}" target="_blank">見る</a></td>
            </tr>
            @endforeach

        </tbody>
        </table>

        @else
        <p>データがありません</p>
        @endif

        {{$app_list->links()}}
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