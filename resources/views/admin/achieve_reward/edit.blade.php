@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 成果報酬管理')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>成果報酬管理</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item"><a href="{{ route('achieve_reward.index') }}">成果報酬管理</a></li>
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
                            <a href="{{ route('achieve_reward.show', $achieve_reward->id) }}" class="btn btn-sm btn-primary" title="編集">
                                <i class="fa fa-edit"></i><span class="hidden-xs"> 表示</span>
                            </a>
                        </div>
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('achieve_reward.index') }}" class="btn btn-sm btn-default" title="一覧">
                                <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('achieve_reward.update', $achieve_reward->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                    <label class="col-sm-2 text-sm-right">支払い</label>
                                    <div class="col-1">
                                        <div class="input-group">
                                            <input name="data[AchieveReward][is_payed]" type="hidden" value="0">
                                            <input name="data[AchieveReward][is_payed]" type="checkbox" class="form-control" value="1" @if($achieve_reward->is_payed) checked @endif >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">支払い日</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input name="data[AchieveReward][payed_at]" type="date" class="form-control" value="{{ substr($achieve_reward->payed_at, 0, 10) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">支払い</label>
                                    <div class="col-1">
                                        <div class="input-group">
                                            <input name="data[AchieveReward][is_payed]" type="hidden" value="0">
                                            <input name="data[AchieveReward][is_payed]" type="checkbox" class="form-control" value="1" @if($achieve_reward->is_payed) checked @endif >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">支払い日</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input name="data[AchieveReward][payed_at]" type="date" class="form-control" value="{{ substr($achieve_reward->payed_at, 0, 10) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">返金依頼</label>
                                    <div class="col-1">
                                        <div class="input-group">
                                            <input name="data[AchieveReward][is_return_requested]" type="hidden" value="0">
                                            <input name="data[AchieveReward][is_return_requested]" type="checkbox" class="form-control" value="1" @if($achieve_reward->is_return_requested) checked @endif >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">返金依頼日</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input name="data[AchieveReward][return_requested_at]" type="date" class="form-control" value="{{ substr($achieve_reward->return_requested_at, 0, 10) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">返金処理を行ったらチェックを入れてください</label>
                                    <div class="col-1">
                                        <div class="input-group">
                                            <input name="data[AchieveReward][is_returned]" type="hidden" value="0">
                                            <input name="data[AchieveReward][is_returned]" type="checkbox" class="form-control" value="1" @if($achieve_reward->is_returned) checked @endif >
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
