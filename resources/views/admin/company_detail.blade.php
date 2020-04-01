<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">企業ID {{$company->id}}</h1>
<span><a href="javascript:void(0)" style="margin-left:10px;" onclick="window.close();">Back</a></span>
@stop

<!-- ページの内容を入力 -->
@section('content')
<div class="col-md-12">
        <div class="card">
                <div class="card-header h5">企業データ</div>
                <div class="card-body">
                    <table class="admin-job-detail-table">
                        @if($company->cname)
                        <tr>
                            <th>会社名</th>
                            <td>
                                <p>{{$company->cname }}</p>
                            </td>
                        </tr>
                        @endif
                        @if($company->foundation)
                        <tr>
                            <th>設立</th>
                            <td>
                                <p>{{$company->foundation }}</p>
                            </td>
                        </tr>
                        @endif
                        @if($company->postcode && $company->prefecture && $company->address)
                        <tr>
                            <th>本社所在地</th>
                            <td>
                                <p>{{$company->cname }}</p>
                            </td>
                        </tr>
                        @endif
                        @if($company->postcode)
                        <tr>
                            <th>会社住所</th>
                            <td>
                                <p>〒{{$company->postcode }}<br>
                                {{$company->prefecture }}<br>
                                {{$company->address }}<br>
                                </p>
                            </td>
                        </tr>
                        @endif
                        @if($company->capital)
                        <tr>
                            <th>資本金</th>
                            <td>
                                <p>{{$company->capital }}</p>
                            </td>
                        </tr>
                        @endif
                        @if($company->employee_number)
                        <tr>
                            <th>従業員数</th>
                            <td>
                                <p>{{$company->employee_number }}</p>
                            </td>
                        </tr>
                        @endif
                        @if($company->description)
                        <tr>
                            <th>事業内容</th>
                            <td>
                                <p>{!! nl2br(e($company->description)) !!}</p>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div> <!-- card --> 

            <div class="card">
                <div class="card-header h5">求人データ({{$jobs->count()}})</div>
                <div class="card-body">
                @if($jobs->isEmpty())
                    <p>データがありません</p>
                @else 
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
                        <td><a href="{{route('admin.job.detail',[$job->id])}}" target="_blank">{{ $job->id}}</a></td>
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
                    
                    @endif
                </div>
            </div> <!-- card --> 

            <div class="card">
                <div class="card-header h5">担当者</div>
                <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">お名前</th>
                        <th scope="col">メールアドレス</th>
                        <th>電話番号</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                        <td>{{$company->employer->last_name}} {{$company->employer->first_name}}</td>
                        <td>{{$company->employer->email}}</td>
                        <td> 
                        {{$company->employer->phone1}}-{{$company->employer->phone2}}-{{$company->employer->phone3}}
                        </td>
                        </tr>

                    </tbody>
                    </table>
                
                </div>
            </div> <!-- card --> 
            
       
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