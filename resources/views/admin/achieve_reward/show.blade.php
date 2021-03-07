@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 成果報酬管理')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>成果報酬管理</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item"><a href="{{ route('achieve_reward.index') }}">成果報酬管理</a></li>
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
                            <a href="{{ route('achieve_reward.index') }}" class="btn btn-sm btn-default" title="一覧">
                                <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                            </a>
                        </div>
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('achieve_reward.edit', $achieve_reward->id) }}" class="btn btn-sm btn-primary" title="編集">
                                <i class="fa fa-edit"></i><span class="hidden-xs"> 編集</span>
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
                                    <p class="system-values-item">{{ $achieve_reward->id }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">登録日時</p>
                                    <p class="system-values-item">{{ $achieve_reward->created_at }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">更新日時</p>
                                    <p class="system-values-item">{{ $achieve_reward->updated_at }}</p>
                                </li>
                            </ul>
                        </div>
                        <hr>
                    </div>
                    <div class="body-box">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">応募</label>
                                <div class="col-sm-8">
                                    <a href="/admin/data/application/{{ $achieve_reward->apply_id }}">{{ $achieve_reward->apply_id }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">支払い</label>
                                <div class="col-sm-8">
                                    @if($achieve_reward->is_payed) 支払い済み @else 未払い @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">支払い日</label>
                                <div class="col-sm-8">
                                    {{ ($achieve_reward->payed_at == null)?"未払い" :$achieve_reward->payed_at->toDateString() }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">返金依頼</label>
                                <div class="col-sm-8">
                                    @if($achieve_reward->is_return_requested) 受付 @else 無し @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">返金依頼日</label>
                                <div class="col-sm-8">
                                    {{ ($achieve_reward->return_requested_at == null)?"無し" :$achieve_reward->return_requested_at->toDateString() }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">返金処理</label>
                                <div class="col-sm-8">
                                    @if($achieve_reward->is_returned) 済み @else 無し @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
