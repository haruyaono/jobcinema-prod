@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 応募管理')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>応募管理</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('application.index') }}">応募管理</a></li>
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
                        <a href="{{ route('application.show', $apply->id) }}" class="btn btn-sm btn-primary" title="編集">
                            <i class="fa fa-edit"></i><span class="hidden-xs"> 表示</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('application.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
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
                <form action="{{ route('application.update', $apply->id) }}" method="POST" accept-charset="UTF-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="data[Application][id]" value="{{ $apply->id }}">
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
                                    <p class="system-values-item"><a href="javascript:void(0);" data-widgetmodal_url="https://demo-jp.exment.net/admin/data/user/1?modal=1" data-toggle="tooltip" title="データ確認"><span class="d-inline-block user-avatar-block">#{{ $apply->user_id ?: '退会済み'}}<br>{{ $apply->detail->full_name }}</span></a></p>
                                </li>
                                <li>
                                    <p class="system-values-label">応募求人</p>
                                    <p class="system-values-item"><a href="javascript:void(0);" data-widgetmodal_url="https://demo-jp.exment.net/admin/data/user/1?modal=1" data-toggle="tooltip" title="データ確認"><span class="d-inline-block user-avatar-block">#{{ $apply->jobitem->id }} {{ $apply->jobitem->company->cname }}</span></a></p>
                                </li>
                                <li>
                                    <p class="system-values-label">応募日</p>
                                    <p class="system-values-item">{{ $apply->created_at->toDateString() }}</p>
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
                                <label class="col-sm-2 text-sm-right">採用ステータス</label>
                                <div class="col-sm-8">
                                    <div class="row mb-2">
                                        <div class="input-group">
                                            <label class="col-form-label font-weight-normal mr-3">応募者</label>
                                            <select class="custom-select" name="data[Application][s_recruit_status]" required="1">
                                                @foreach(config('const.RECRUITMENT_STATUS') as $key => $value)
                                                <option value="{{ $key }}" @if(old('data.Application.s_recruit_status')===(string) $key){{ 'selected' }}@else{{ !old('data.Application.s_recruit_status') && old('data.Application.s_recruit_status') !== '0' && $key === $apply->s_recruit_status ? 'selected' : ''}}@endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-group">
                                            <label class="col-form-label font-weight-normal mr-3">企業　</label>
                                            <select class="custom-select" name="data[Application][e_recruit_status]" required="1">
                                                @foreach(config('const.RECRUITMENT_STATUS') as $key => $value)
                                                <option value="{{ $key }}" @if(old('data.Application.e_recruit_status')===(string) $key){{ 'selected' }}@else{{ !old('data.Application.e_recruit_status') && old('data.Application.e_recruit_status') !== '0' && $key === $apply->e_recruit_status ? 'selected' : ''}}@endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">初出社日</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="input-group">
                                        <label class="col-form-label font-weight-normal mr-3">応募者</label>
                                        <input type="text" id="s_first_attendance" name="data[Application][s_first_attendance]" class="form-control" value="@if(old('data.Application.s_first_attendance')){{ old('data.Application.s_first_attendance') }}@else{{ $apply->s_first_attendance ? $apply->s_first_attendance : '' }}@endif" placeholder="初出社日">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group">
                                        <label class="col-form-label font-weight-normal mr-3">企業　</label>
                                        <input type="text" id="e_first_attendance" name="data[Application][e_first_attendance]" class="form-control" value="@if(old('data.Application.e_first_attendance')){{ old('data.Application.e_first_attendance') }}@else{{ $apply->e_first_attendance ? $apply->e_first_attendance : '' }}@endif" placeholder="初出社日">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">初出社日が未定の理由</label>
                            <div class="col-sm-8">
                                <div class="row mb-2">
                                    <div class="input-group">
                                        <label class="col-form-label font-weight-normal mr-3">応募者</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[Application][s_nofirst_attendance]" class="form-control" placeholder="入力 初出社日が未定の理由">{{ old('data.Application.s_nofirst_attendance') ?: $apply->s_nofirst_attendance }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-group">
                                        <label class="col-form-label font-weight-normal mr-3">企業　</label>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[Application][e_nofirst_attendance]" class="form-control" placeholder="入力 初出社日が未定の理由">{{ old('data.Application.e_nofirst_attendance') ?: $apply->e_nofirst_attendance }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row  align-items-center">
                            <label class="col-sm-2 text-sm-right">お祝い金フラグ</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <select class="custom-select" name="data[Application][congrats_status]" required="1">
                                        @foreach(config('const.CONGRAT_STATUS') as $key => $value)
                                        {{ var_dump(!old('data.Application.congrats_status')) }}
                                        <option value="{{ $key }}" @if(old('data.Application.congrats_status')===(string) $key){{ 'selected' }}@else{{ !old('data.Application.congrats_status') && old('data.Application.congrats_status') !== '0' && $key === $apply->congrats_status ? 'selected' : ''}}@endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row align-items-center">
                            <label class="col-sm-2 text-sm-right">お祝い金の金額</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" name="data[Application][congrats_amount]" value="{{ old('data.Application.congrats_amount') ?: $apply->congrats_amount }}" class="form-control" placeholder="入力 お祝い金の金額"><span class="mt-1 ml-2">円</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row  align-items-center">
                            <label class="col-sm-2 text-sm-right">成果報酬フラグ</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <select class="custom-select" name="data[Application][recruitment_status]" required="1">
                                        @foreach(config('const.RECRUITMENT_REWARDS_STATUS') as $key => $value)
                                        <option value="{{ $key }}" @if(old('data.Application.recruitment_status')===(string) $key ){{ 'selected' }}@else{{ !old('data.Application.recruitment_status') &&  old('data.Application.recruitment_status') !== '0' && $key === $apply->recruitment_status ? 'selected' : ''}}@endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row align-items-center">
                            <label class="col-sm-2 text-sm-right">成果報酬の金額</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" name="data[Application][recruitment_fee]" value="{{ old('data.Application.recruitment_fee') ?: $apply->recruitment_fee }}" class="form-control" placeholder="入力 成果報酬の金額"><span class="mt-1 ml-2">円</span>
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
        $('#s_first_attendance').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja',
        });

        $('#e_first_attendance').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja',
        });
    });
</script>
@stop
