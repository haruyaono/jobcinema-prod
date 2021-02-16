@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 広告管理')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>広告管理</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item"><a href="{{ route('ad_item.index') }}">広告管理</a></li>
    <li class="breadcrumb-item active">詳細</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">詳細</h3>
                    <div class="card-tools">
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('ad_item.index') }}" class="btn btn-sm btn-default" title="一覧">
                                <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                            </a>
                        </div>
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('ad_item.edit', $adItem->id) }}" class="btn btn-sm btn-primary" title="編集">
                                <i class="fa fa-edit"></i><span class="hidden-xs"> 編集</span>
                            </a>
                        </div>
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger {{ $adItem->id }}-delete" title="削除">
                                <i class="fa fa-trash"></i><span class="hidden-xs"> 削除</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="system-values">
                            <div class="system-values-flows">
                            </div>
                            <ul class="system-values-list">
                                <li>
                                    <p class="system-values-label">ID</p>
                                    <p class="system-values-item">{{ $adItem->id }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">作成日時</p>
                                    <p class="system-values-item">{{ $adItem->created_at }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">更新日時</p>
                                    <p class="system-values-item">{{ $adItem->created_at }}</p>
                                </li>
                            </ul>
                        </div>
                        <hr>
                    </div>
                    <div class="body-box">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">広告掲載企業</label>
                                <div class="col-sm-8">
                                    <a href="{{"/admin/data/enterprise/".$adItem->company_id}}}">{{ $adItem->company->cname }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">広告求人</label>
                                <div class="col-sm-8">
                                    <a href="{{"/admin/data/job_sheet/".$adItem->job_item_id}}">{{ $adItem->jobItem->job_title }}</a>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">画像</label>
                                <div class="col-sm-8">
                                    <img src="{{ $adItem->image_path }}" alt="{{ $adItem->description }}" />
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">説明</label>
                                <div class="col-sm-8">
                                    <p>{{ $adItem->description }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">料金</label>
                                <div class="col-sm-8">
                                    <p>{{ $adItem->price }}円</p>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">掲載</label>
                                <div class="col-sm-8">
                                    <p>@if($adItem->is_view)掲載中@else未掲載@endif</p>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">掲載開始日時</label>
                                <div class="col-sm-8">
                                    <p>{{ $adItem->started_at }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">掲載終了日時</label>
                                <div class="col-sm-8">
                                    <p>{{ $adItem->ended_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @stop

        @section('js')
            <script>
                $(function() {
                    $('.{{$adItem->id}}-delete').click(function(event) {
                        deleteItem('/admin/data/ad_item/', '{{$adItem->id}}', '/admin/data/ad_item');
                    });
                });
            </script>
@stop
