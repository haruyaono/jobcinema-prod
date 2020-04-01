<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', 'Dashboard')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">承認待ちの求人</h1>
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
        @if(!$jobs->isEmpty())
        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">求人番号</th>
            <th>会社</th>
            <th scope="col">ステータス</th>
            <th>お祝い金</th>
            <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)

            <tr>
            <td><a href="{{route('admin.job.detail',[$job->id])}}">{{ $job->id}}</a></td>
            <td>{{$job->company->cname}}</td>
            <td> @if($job->status=='0')
                <span>下書き</span> 
                @elseif($job->status=='1')
                <span>承認待ち</span> 
                @elseif($job->status=='2')
                <span>公開中</span> 
                @elseif($job->status=='3')
                <span>非公開</span> 
                @endif
            </td>
            <td> @if(!$job->oiwaikin)
                <span>なし</span> 
                @else
                <span>対象</span> 
                @endif
                <a href="{{route('admin.job.oiwaikin.change', [$job->id])}}" @if(!$job->oiwaikin) onclick="return window.confirm('「お祝い金」を設定しますか？');" @else onclick="return window.confirm('「お祝い金」を解除しますか？');" @endif>変更</a>
            </td>
            <td>
                @if($job->status=='0')
                    <a href="{{route('job.delete',[$job->id])}}" class="text-danger"> 削除</a>
                @elseif($job->status=='1')
                    <a href="{{route('job.approve',[$job->id])}}" class="label label-info"> 承認</a>
                    <a href="{{route('job.non.approve',[$job->id])}}" class="label label-default"> 非承認</a>
                    <a href="{{route('job.delete',[$job->id])}}" class="text-danger" onclick="return window.confirm('「削除」で間違いありませんか？');"> 削除</a>
                @elseif($job->status=='2')
                    <a href="{{route('job.non.approve',[$job->id])}}" class="label label-default"> 非承認</a>
                    <a href="{{route('job.delete',[$job->id])}}" class="text-danger"> 削除</a>
                @elseif($job->status=='3')
                    <a href="{{route('job.approve',[$job->id])}}" class="label label-info"> 承認</a>
                    <a href="{{route('job.delete',[$job->id])}}" class="text-danger"> 削除</a>
                @endif
            </td>
            </tr>
            @endforeach

        </tbody>
        </table>
        @else
        <p>データがありません</p>
        @endif

        {{$jobs->links()}}
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