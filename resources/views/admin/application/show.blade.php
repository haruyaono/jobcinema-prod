@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 応募管理')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>応募管理</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('application.index') }}">応募管理</a></li>
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
                        <a href="{{ route('application.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('application.edit', $apply->id) }}" class="btn btn-sm btn-primary" title="編集">
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
                                <p class="system-values-item">{{ $apply->id }}</p>
                            </li>
                            <li>
                                <p class="system-values-label">応募者</p>
                                <p class="system-values-item"><a href="javascript:void(0);" data-toggle="tooltip" title="データ確認"><span class="d-inline-block user-avatar-block">#{{ $apply->user_id ?: '退会済み'}}<br>{{ $apply->detail->full_name }}</span></a></p>
                            </li>
                            <li>
                                <p class="system-values-label">応募求人</p>
                                <p class="system-values-item"><a href="javascript:void(0);" data-toggle="tooltip" title="データ確認"><span class="d-inline-block user-avatar-block">#{{ $apply->jobitem->id }} {{ $apply->jobitem->company->cname }}</span></a></p>
                            </li>
                            <li>
                                <p class="system-values-label">応募日</p>
                                <p class="system-values-item">{{ $apply->created_at->toDateString() }}</p>
                            </li>
                        </ul>
                    </div>
                    <hr>
                </div>
                <div class="body-box">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">採用ステータス</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <label class="mr-2">応募者 : </label>
                                    <p>{{ config('const.RECRUITMENT_STATUS.' . $apply->s_recruit_status) }}</p>
                                </div>
                                <div class="row">
                                    <label class="mr-2">企業 : </label>
                                    <p>{{ config('const.RECRUITMENT_STATUS.' . $apply->e_recruit_status) }}</p>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">初出社日</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <label class="mr-2">応募者 : </label>
                                    <p>{{ $apply->s_first_attendance ?: '未入力' }}</p>
                                </div>
                                <div class="row">
                                    <label class="mr-2">企業 : </label>
                                    <p>{{ $apply->e_first_attendance ?: '未入力' }}</p>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">初出社日が未定</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <label class="mr-2">応募者 : </label>
                                    <p>{!! nl2br(e($apply->s_nofirst_attendance)) ?: '未入力' !!}</p>
                                </div>
                                <div class="row">
                                    <label class="mr-2">企業 : </label>
                                    <p>{!! nl2br(e( $apply->e_nofirst_attendance)) ?: '未入力' !!}</p>

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">お祝い金フラグ</label>
                                <div class="col-sm-8">
                                    {{ config('const.CONGRAT_STATUS.' . $apply->congrats_status) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">お祝い金の金額</label>
                                <div class="col-sm-8">
                                    {{ $apply->custom_congrats_amount }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">採用報酬フラグ</label>
                                <div class="col-sm-8">
                                    {{ config('const.RECRUITMENT_REWARDS_STATUS.' . $apply->recruitment_status) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">採用報酬の金額</label>
                                <div class="col-sm-8">
                                    {{ $apply->custom_recruitment_fee }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
