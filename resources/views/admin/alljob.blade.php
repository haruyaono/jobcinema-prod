<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">求人一覧</h1>
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
        <form name="sort" action="{{route('alljob.get')}}" method="get">
            <select id="job_status01" name="created_at" >
                <option value="desc" @if(isset($param['created_at']) && $param['created_at']=='desc') selected @endif>新しい順</option>
                <option value="asc" @if(isset($param['created_at']) && $param['created_at']=='asc') selected @endif>古い順</option> 
            </select>
            <select id="job_status02" name="status">
                <option value="">---</option>
                <option value="0" @if(isset($param['status']) && $param['status']=='0') selected @endif>一時保存中</option>
                <option value="1" @if(isset($param['status']) && $param['status']=='1') selected @endif>承認待ち</option>
                <option value="2" @if(isset($param['status']) && $param['status']=='2') selected @endif> 掲載中</option>
                <option value="3" @if(isset($param['status']) && $param['status']=='3') selected @endif>非承認</option>
                <option value="4" @if(isset($param['status']) && $param['status']=='4') selected @endif>公開停止中</option>
                <option value="5" @if(isset($param['status']) && $param['status']=='5') selected @endif>削除申請中</option>
                <option value="6" @if(isset($param['status']) && $param['status']=='6') selected @endif>完全非公開</option>
            </select>
            <select id="oiwaikin_status" name="oiwaikin">
                <option value="">---</option>
                <option value="3000" @if(isset($param['oiwaikin']) && $param['oiwaikin']==3000) selected @endif>お祝い金対象</option>
                <option value="not" @if(isset($param['oiwaikin']) && $param['oiwaikin']=='not') selected @endif>お祝い金非対象</option>
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
                @if($job->status != '2' || $job->status !='5')
                    <a href="{{route('job.status.change',[$job->id, 'status_approve'])}}" class="label label-info"> 公開</a>
                @endif
                @if($job->status != '6')
                    <a href="{{route('job.status.change',[$job->id, 'status_non_public'])}}" class="label label-default"> 非公開</a>
                @endif
                @if($job->status == '2')
                    <a href="{{route('job.status.change',[$job->id, 'status_non_approve'])}}" class="label label-default"> 非承認</a>
                @endif
                <a href="{{route('job.delete',[$job->id])}}" class="text-danger" onclick="return window.confirm('「削除」で間違いありませんか？');"> 削除</a>
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