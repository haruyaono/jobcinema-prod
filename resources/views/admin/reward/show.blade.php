@extends('adminlte::page')

@section('title', 'JOB CiNEMA | お祝い金管理')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>お祝い金管理</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('reward.index') }}">お祝い金管理</a></li>
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
                        <a href="{{ route('reward.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('reward.edit', $reward->id) }}" class="btn btn-sm btn-primary" title="編集">
                            <i class="fa fa-edit"></i><span class="hidden-xs"> 編集</span>
                        </a>
                    </div>
                    <!-- <div class="btn-group" style="margin-right: 5px">
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger 5fba2c4c996fa-delete" title="削除">
                            <i class="fa fa-trash"></i><span class="hidden-xs"> 削除</span>
                        </a>
                    </div> -->
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
                                <p class="system-values-item">{{ $jobitem->id }}</p>
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
                <div class="body-box">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">ステータス</label>
                            <div class="col-sm-8">
                                <p>{{ config('const.CONGRAT_PAYMENT_STATUS.' . $reward->status) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">支払日</label>
                            <div class="col-sm-8">
                                {{ $reward->payment_date ?: '未払い' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
