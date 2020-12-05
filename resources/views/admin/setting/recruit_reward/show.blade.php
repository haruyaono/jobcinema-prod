@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 採用報酬設定')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>採用報酬設定</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('recruit_reward.index') }}">採用報酬設定</a></li>
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
                        <a href="{{ route('recruit_reward.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('recruit_reward.edit', $reward->id) }}" class="btn btn-sm btn-primary" title="編集">
                            <i class="fa fa-edit"></i><span class="hidden-xs"> 編集</span>
                        </a>
                    </div>
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger {{ $reward->id }}-delete" title="削除">
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
                                <p class="system-values-item">{{ $reward->id }}</p>
                            </li>
                            <li>
                                <p class="system-values-label">作成日時</p>
                                <p class="system-values-item">{{ $reward->created_at }}</p>
                            </li>
                            <li>
                                <p class="system-values-label">更新日時</p>
                                <p class="system-values-item">{{ $reward->created_at }}</p>
                            </li>
                        </ul>
                    </div>
                    <hr>
                </div>
                <div class="body-box">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">金額</label>
                            <div class="col-sm-8">
                                <p>{{ $reward->custom_amount }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">カテゴリ</label>
                            <div class="col-sm-8">
                                <p>{{ $reward->category->name }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-2 text-sm-right">ラベル</label>
                            <div class="col-sm-8">
                                <p>{{ $reward->label }}</p>
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
            $('.{{$reward->id}}-delete').click(function(event) {
                deleteItem('/admin/setting/recruit_reward/', '{{$reward->id}}', '/admin/setting/recruit_reward');
            });
        });
    </script>
    @stop
