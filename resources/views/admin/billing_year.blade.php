<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">課金管理</h1>
<span><a href="javascript:void(0)" style="margin-left:10px;" onclick="history.back(); return false">Back</a></span>
  
    @if(Session::has('message'))
    <div class="alert alert-success" style="margin-top:15px;">{{Session::get('message')}}</div>
    @endif
@stop

<!-- ページの内容を入力 -->
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-body">

            <div class="billing-year-top">
                <p>
                    <a href="{{ route('billing.year', ['year' => $month_list->year, 'month' => $month_list->month]) }}">
                        {{ $month_list->year_month }}
                    </a>
                </p>
                <p>
                    発生：{{$app_list->count()}} 件
                </p>
                <p>
                    金額：{{$total}} 円
                </p>
            </div>

            <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">発生日</th>
                <th scope="col">ユーザーID</th>
                <th>名前</th>
                <th scope="col">初出社日</th>
                <th>お祝い金申請</th>
                <th scope="col">採用結果</th>
                <th scope="col">応募先</th>
                </tr>
            </thead>
            <tbody>
                @forelse($app_list as $app_item)
                <tr>
                <?php 
                    $day = $app_item->created_at;
                ?>
                <td>{{ $day}}</td>
                <td>{{ $app_item->user_id}}
                    @if(!App\Models\User::where('id',$app_item->user_id)->exists())
                    (削除済み)
                    @endif
                </td>
                <td><a href="{{route('user.detail.get', [$app_item->id])}}">{{ $app_item->last_name}} {{ $app_item->first_name}}</a></td>
                <td>{{ $app_item->first_attendance}}</td>
                <td>
                    @if($app_item->oiwaikin)
                    あり {{ $app_item->oiwaikin}}円
                    @else 
                    なし
                    @endif
                </td>
                <td>{{config("const.JOB_STATUS.{$app_item->e_status}", "未定義")}}</td>
                <td><a href="{{route('admin.job.detail',[$app_item->job_item_id])}}" target="_blank">見る</a></td>
                </tr>
                @empty
                    <p>データがありません。</p>
                @endforelse

            </tbody>
            </table>

            {{$app_list->links()}}
                
        </div>
    </div>
</div>


@stop

<!-- 読み込ませるCSSを入力 -->
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/admin.css">
@stop

<!-- 読み込ませるJSを入力 -->
@section('js')

@stop