<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">課金管理</h1>
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

            <ul class="nav nav-tabs">
                <li class="nav-item active">
                <a href="#photo1" class="nav-link active" data-toggle="tab">月別</a>
                </li>
                <li class="nav-item">
                <a href="#photo2" class="nav-link" data-toggle="tab">企業別</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="photo1" class="tab-pane active">
                    <div class="monthly_archive">
                    @forelse($month_list as $value)
                        <p>
                            <a href="{{ route('billing.year', ['year' => $value->year, 'month' => $value->month]) }}">
                                {{ $value->year_month }}
                            </a>
                        </p>
                    @empty
                        <p>データがありません</p>
                    @endforelse 
                    </div>
                </div>
                <div id="photo2" class="tab-pane">
                @if(empty($applyJobItemList))
                    <p>データがありません</p>
                @else 
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">企業ID</th>
                        <th scope="col">企業名</th>
                        <th scope="col">求人数</th>
                        <th scope="col">発生件数</th>
                        <th scope="col">金額</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applyJobItemList as $applyJobItem)
                        <tr>
                        <td><a href="{{route('admin.company.detail',[$applyJobItem->company->id])}}" target="_blank">{{ $applyJobItem->company->id}}</a>
                        </td>
                        <td>{{ $applyJobItem->company->cname}}</a></td>
                        <td>{{ $applyJobItem->company->jobs->count()}}</td>
                        <?php 
                            $appTotalMoney = number_format($applyJobItem->tatal * 30000);
                        ?>
                        <td>{{ $applyJobItem->tatal }}</td>
                        <td>{{ $appTotalMoney }} 円</td>
                        </tr>   
                        @endforeach
                    </tbody>
                </table>
                @endif
                </div>
            </div>
        
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