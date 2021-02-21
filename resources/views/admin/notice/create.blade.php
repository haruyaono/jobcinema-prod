@extends('adminlte::page')

@section('title', 'JOB CiNEMA | お知らせ管理')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>お知らせ管理</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item"><a href="{{ route('notice.index') }}">お知らせ管理</a></li>
    <li class="breadcrumb-item active">新規</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">作成</h3>
                    <div class="card-tools">
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('notice.index') }}" class="btn btn-sm btn-default" title="一覧">
                                <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('notice.store') }}" method="POST" accept-charset="UTF-8">
                        @csrf
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
                                            <input type="text" id="subject" class="form-control" placeholder="入力　件名" name="data[Notice][subject]" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">本文</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <textarea id="content" class="form-control" placeholder="入力　本文" name="data[Notice][content]" required></textarea>
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
                                                <option value="全体">全体</option>
                                                <option value="企業">企業</option>
                                                <option value="応募者">応募者</option>
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
                                            <input type="checkbox" id="is_delivered" class="form-control" name="data[Notice][is_delivered]" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-8 text-right">
                                    <div class="btn-group">
                                        <button id="admin-submit" type="submit" class="btn btn-primary">作成</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop