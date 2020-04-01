<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">求人一覧</h1>
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
        <form name="sort" action="{{route('alljob.sort')}}" method="get">
            <select id="job_status" name="job_status">
                <option value="createLate" {{$sortBy1=='createLate'?'selected':''}}>新しい順</option>
                <option value="createOld" {{$sortBy1=='createOld'?'selected':''}}>古い順</option>
                <option value="status_1" {{$sortBy1=='status_1'?'selected':''}}>承認待ち</option>
                <option value="status_5" {{$sortBy1=='status_5'?'selected':''}}>削除申請</option>
                <option value="status_6" {{$sortBy1=='status_6'?'selected':''}}>完全非公開</option>
            </select>
            <select id="oiwaikin_status" name="oiwaikin_status">
                <option value="">---</option>
                <option value="oiwaikin_true" {{$sortBy2=='oiwaikin_true'?'selected':''}}>お祝い金対象</option>
                <option value="oiwaikin_false" {{$sortBy2=='oiwaikin_false'?'selected':''}}>お祝い金非対象</option>
            </select>

            <button type="submit">検索</button>
        </form>

        <br>

        @if(!$jobs->isEmpty())

        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">求人番号</th>
            <!-- <th scope="col">作成日</th> -->
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
            <!-- <th scope="row">{{date('Y-m-d',strtotime($job->created_at))}}</th> -->
            <td>{{$job->company->cname}}</td>
            <td> @if($job->status=='0')
                <span>一時保存中</span> 
                @elseif($job->status=='1')
                <span>承認待ち</span> 
                @elseif($job->status=='2')
                <span>掲載中</span> 
                @elseif($job->status=='3')
                <span>非承認</span> 
                @elseif($job->status=='4')
                <span>公開停止中</span> 
                @elseif($job->status=='5')
                <span>削除申請中</span> 
                @elseif($job->status=='6')
                <span>完全非公開</span> 
                @endif
            </td>
            <td> @if(!$job->oiwaikin)
                <span>なし</span> 
                @else
                <span>対象</span> 
                @endif
                <a href="{{route('admin.job.oiwaikin.change', [$job->id])}}" @if(!$job->oiwaikin) onclick="return window.confirm('「お祝い金」を設定しますか？');" @else onclick="return window.confirm('「お祝い金」を解除しますか？');" @endif>変更</a>
            </td>
            <td class="text-right">
                @if($job->status=='0')
                    <a href="{{route('job.approve',[$job->id])}}" class="label label-info"> 公開</a>
                    <a href="{{route('job.non.public',[$job->id])}}" class="label label-default"> 非公開</a>
                    <a href="{{route('job.delete',[$job->id])}}" class="text-danger" onclick="return window.confirm('「削除」で間違いありませんか？');"> 削除</a>
                @elseif($job->status=='1')
                    <a href="{{route('job.approve',[$job->id])}}" class="label label-info"> 公開</a>
                    <a href="{{route('job.non.public',[$job->id])}}" class="label label-default"> 非公開</a>
                    <a href="{{route('job.delete',[$job->id])}}" class="text-danger" onclick="return window.confirm('「削除」で間違いありませんか？');"> 削除</a>
                @elseif($job->status=='2')
                    <a href="{{route('job.non.approve',[$job->id])}}" class="label label-default"> 非承認</a>
                    <a href="{{route('job.non.public',[$job->id])}}" class="label label-default"> 非公開</a>
                    <a href="{{route('job.delete',[$job->id])}}" class="text-danger" onclick="return window.confirm('「削除」で間違いありませんか？');"> 削除</a>
                @elseif($job->status=='3')
                    <a href="{{route('job.approve',[$job->id])}}" class="label label-info"> 公開</a>
                    <a href="{{route('job.non.public',[$job->id])}}" class="label label-default"> 非公開</a>
                    <a href="{{route('job.delete',[$job->id])}}" class="text-danger" onclick="return window.confirm('「削除」で間違いありませんか？');"> 削除</a>
                @elseif($job->status=='4')
                <a href="{{route('job.approve',[$job->id])}}" class="label label-info"> 公開</a>
                <a href="{{route('job.non.public',[$job->id])}}" class="label label-default"> 非公開</a>
                <a href="{{route('job.delete',[$job->id])}}" class="text-danger" onclick="return window.confirm('「削除」で間違いありませんか？');"> 削除</a>
                @elseif($job->status=='5')
                <a href="{{route('job.non.public',[$job->id])}}" class="label label-default"> 非公開</a>
                <a href="{{route('job.delete',[$job->id])}}" class="text-danger" onclick="return window.confirm('「削除」で間違いありませんか？');"> 削除</a>
                @elseif($job->status=='6')
                <a href="{{route('job.approve',[$job->id])}}" class="label label-info"> 公開</a>
                <a href="{{route('job.delete',[$job->id])}}" class="text-danger" onclick="return window.confirm('「削除」で間違いありませんか？');"> 削除</a>
        
                @endif
            </td>
            </tr>
            @endforeach

        </tbody>
        </table>

        @else
        <p>データがありません</p>
        @endif

        {{ $jobs->appends(Illuminate\Support\Facades\Input::except('page'))->links()}}
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