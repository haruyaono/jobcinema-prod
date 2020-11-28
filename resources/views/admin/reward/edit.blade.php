@extends('adminlte::page')

@section('title', 'JOB CiNEMA | お祝い金管理')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>お祝い金管理</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('reward.index') }}">お祝い金管理</a></li>
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
                        <a href="{{ route('reward.show', $reward->id) }}" class="btn btn-sm btn-primary" title="編集">
                            <i class="fa fa-edit"></i><span class="hidden-xs"> 表示</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('reward.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('reward.update', $reward->id) }}" method="POST" accept-charset="UTF-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="data[Reward][id]" value="{{ $reward->id }}">
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
                                    <p class="system-values-label">応募者</p>
                                    <p class="system-values-item"><a href="javascript:void(0);" data-toggle="tooltip" title="データ確認"><span class="d-inline-block">#{{ $reward->user_id ?: '退会済み'}}<br>{{ $reward->user->full_name }}</span></a></p>
                                </li>
                                <li>
                                    <p class="system-values-label">応募データ</p>
                                    <p class="system-values-item"><a href="javascript:void(0);" data-toggle="tooltip" title="データ確認"><span class="d-inline-block">#{{ $reward->apply->id }}</span></a></p>
                                </li>
                                <li>
                                    <p class="system-values-label">申請日</p>
                                    <p class="system-values-item">{{ $reward->created_at }}</p>
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
                                <label class="col-sm-2 text-sm-right">ステータス</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <select class="custom-select" name="data[Reward][status]" required="1">
                                            @foreach(config('const.CONGRAT_PAYMENT_STATUS') as $key => $value)
                                            <option value="{{ $key }}" @if(old('data.Reward.status')===(string) $key){{ 'selected' }}@else{{ !old('data.Reward.status') && old('data.Reward.status') !== '0' && $key === $reward->status ? 'selected' : ''}}@endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">金額</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="billing_amount" name="data[Reward][billing_amount]" class="form-control" value="@if(old('data.Reward.billing_amount')){{ old('data.Reward.billing_amount') }}@else{{ $reward->billing_amount ? $reward->billing_amount : '' }}@endif" placeholder="入力　金額"><span class="mt-1 ml-2">円</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">支払日</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="payment_date" name="data[Reward][payment_date]" class="form-control" value="@if(old('data.Reward.payment_date')){{ old('data.Reward.payment_date') }}@else{{ $reward->payment_date ?  $reward->payment_date->format('Y-m-d H:i'): '' }}@endif" placeholder="入力　支払日">
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
        $('#payment_date').datetimepicker({
            format: 'Y-m-d H:i'
        });
    });
</script>
@stop
