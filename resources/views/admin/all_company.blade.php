<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">企業一覧</h1>
<span><a href="{{route('admin.home')}}" style="margin-left:10px;">Back</a></span>
  
    @if(Session::has('message'))
    <div class="alert alert-success" style="margin-top:15px;">{{Session::get('message')}}</div>
    @endif
    @if(Session::has('message2'))
    <div class="alert alert-success" style="margin-top:15px;">{{Session::get('message2')}}</div>
    @endif
@stop

<!-- ページの内容を入力 -->
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-body">

        <form name="sort" action="{{route('all.company.get')}}" method="get">
            <select id="c_status01" name="created_at" >
                <option value="desc" @if(isset($param['created_at']) && $param['created_at']=='desc') selected @endif>新しい順</option>
                <option value="asc" @if(isset($param['created_at']) && $param['created_at']=='asc') selected @endif>古い順</option>
            </select>
            <select id="c_status02" name="c_status">
                <option value="">---</option>
                <option value="0" @if(isset($param['c_status']) && $param['c_status']=='0') selected @endif>仮登録</option>
                <option value="1" @if(isset($param['c_status']) && $param['c_status']=='1') selected @endif>本登録</option>
                <option value="2" @if(isset($param['c_status']) && $param['c_status']=='2') selected @endif>メール認証済</option>
                <option value="8" @if(isset($param['c_status']) && $param['c_status']=='8') selected @endif>退会申請中</option>
                <option value="9" @if(isset($param['c_status']) && $param['c_status']=='9') selected @endif>退会済</option>
            </select>
            <button type="submit">検索</button>
        </form>
        <br>

        @if(!$companies->isEmpty())

        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">企業ID</th>
            <th scope="col">企業名</th>
            <th>求人数</th>
            <th scope="col">ステータス</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)

            <tr>
            <td>{{$company->id}}</td>
            <td>{{$company->cname}}</td>
            <td>{{$company->jobs->count()}}</td>
            <td> @if($company->employer->status == '0')
                <span>仮登録</span> 
                @elseif($company->employer->status=='1')
                <span>本登録</span> 
                @elseif($company->employer->status=='2')
                <span>メール認証済</span> 
                @elseif($company->employer->status=='8')
                <span>退会申請中</span> 
                @elseif($company->employer->status=='9')
                <span>退会済</span> 
                @endif
            </td>
            <td class="text-right">
                <a href="{{route('admin.company.delete',[$company->employer->id])}}" class="text-danger" onclick="return window.confirm('「削除」で間違いありませんか？');"> 削除</a>
            </td>
            <td><a href="{{route('admin.company.detail',[$company->id])}}">見る</a></td>
            </tr>
            @endforeach

        </tbody>
        </table>

        @else
        <p>データがありません</p>
        @endif

        {{ $companies->appends(Illuminate\Support\Facades\Input::except('page'))->links()}}
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