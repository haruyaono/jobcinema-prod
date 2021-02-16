@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 広告管理')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>広告管理</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item"><a href="{{ route('ad_item.index') }}">広告管理</a></li>
    <li class="breadcrumb-item active">編集</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">編集</h3>
                    <div class="card-tools">
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('ad_item.show', $adItem->id) }}" class="btn btn-sm btn-primary" title="編集">
                                <i class="fa fa-edit"></i><span class="hidden-xs"> 表示</span>
                            </a>
                        </div>
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('ad_item.index') }}" class="btn btn-sm btn-default" title="一覧">
                                <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
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
                    <form action="{{ route('ad_item.update', $adItem->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong><i class="fas fa-exclamation-circle"></i>エラー</strong><br>
                                <ul class="list-unstyled">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="body-box">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">広告掲載元</label>
                                    <div class="col-sm-8">
                                        <div>
                                            <p>{{ $adItem->company->cname }}</p>
                                            <p>{{ $adItem->jobItem->job_title }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">画像ファイル</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="file" accept="image/jpeg,image/png" class="form-control" name="data[AdItem][image]">
                                        </div>
                                        <img src="{{ $adItem->image_path }}" alt="{{ $adItem->description }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">説明</label>
                                    <div class="col-sm-8">
                                        <p>{{ $adItem->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">料金</label>
                                    <div class="col-sm-8">
                                        <p>{{ $adItem->price }}円</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">掲載</label>
                                    <div class="col-1">
                                        <div class="input-group">
                                            <input name="data[AdItem][is_view]" type="hidden" value="0">
                                            <input type="checkbox" id="description" class="form-control" placeholder="入力　説明" name="data[AdItem][is_view]" required value="1"
                                            @if($adItem->is_view)
                                                checked
                                            @endif
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">掲載開始日時</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="date" id="started_at" class="form-control" name="data[AdItem][started_at]" required value="{{ substr($adItem->started_at, 0, 10) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">掲載終了日時</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="date" id="ended_at" class="form-control" name="data[AdItem][ended_at]" required value="{{ substr($adItem->ended_at, 0, 10) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8 text-right">
                                <div class="btn-group">
                                    <button id="admin-submit" type="submit" class="btn btn-primary">保存</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
