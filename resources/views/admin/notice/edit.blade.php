@extends('adminlte::page')

@section('title', 'JOB CiNEMA | お知らせ管理')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>お知らせ管理</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item"><a href="{{ route('notice.index') }}">お知らせ管理</a></li>
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
                            <a href="{{ route('notice.show', $notice->id) }}" class="btn btn-sm btn-primary" title="編集">
                                <i class="fa fa-edit"></i><span class="hidden-xs"> 表示</span>
                            </a>
                        </div>
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('notice.index') }}" class="btn btn-sm btn-default" title="一覧">
                                <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                            </a>
                        </div>
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger {{ $notice->id }}-delete" title="削除">
                                <i class="fa fa-trash"></i><span class="hidden-xs"> 削除</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('notice.update', $notice->id) }}" method="POST" accept-charset="UTF-8">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <div class="system-values">
                                <div class="system-values-flows">
                                </div>
                                <ul class="system-values-list">
                                    <li>
                                        <p class="system-values-label">ID</p>
                                        <p class="system-values-item">{{ $notice->id }}</p>
                                    </li>
                                    <li>
                                        <p class="system-values-label">作成日時</p>
                                        <p class="system-values-item">{{ $notice->created_at }}</p>
                                    </li>
                                    <li>
                                        <p class="system-values-label">更新日時</p>
                                        <p class="system-values-item">{{ $notice->created_at }}</p>
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
                                    <label class="col-sm-2 text-sm-right">件名</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="subject" class="form-control" placeholder="入力　件名" name="data[Notice][subject]" required value="{{ $notice->subject }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">本文</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <textarea id="content" class="form-control" placeholder="入力　本文" name="data[Notice][content]" required>{{ $notice->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">対象</label>
                                    <div class="col-sm-8">
                                        <div>
                                            <select id="target" class="custom-select" name="data[Notice][target]" required>
                                                <option value="">配信対象の選択</option>
                                                <option value="全体" @if($notice->target == "全体") selected @endif >全体</option>
                                                <option value="企業" @if($notice->target == "企業") selected @endif >企業</option>
                                                <option value="応募者" @if($notice->target == "応募者") selected @endif >応募者</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">配信</label>
                                    <div class="col-1">
                                        <div class="input-group">
                                            <input name="data[Notice][is_delivered]" type="hidden" value="0">
                                            <input type="checkbox" id="is_delivered" class="form-control" name="data[Notice][is_delivered]" value="1"
                                                   @if($notice->is_delivered)
                                                   checked
                                                    @endif
                                            >
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
            $('.{{$notice->id}}-delete').click(function(event) {
                deleteItem('/admin/data/notice/', '{{$notice->id}}', '/admin/data/notice');
            });
        });
    </script>
@stop
