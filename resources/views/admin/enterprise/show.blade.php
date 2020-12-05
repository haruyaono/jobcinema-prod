@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 企業テーブル')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>企業テーブル</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('job_sheet.index') }}">企業テーブル</a></li>
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
                        <a href="{{ route('enterprise.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('enterprise.edit', $enterprise->id) }}" class="btn btn-sm btn-primary" title="編集">
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
                                <p class="system-values-item">{{ $enterprise->id }}</p>
                            </li>
                            <li>
                                <p class="system-values-label">企業</p>
                                <p class="system-values-item"><a href="javascript:void(0);" data-toggle="tooltip" title="データ確認"><span class="d-inline-block user-avatar-block">#{{ $enterprise->id }} {{ $enterprise->cname }}</span></a></p>
                            </li>
                            <li>
                                <p class="system-values-label">採用担当</p>
                                <p class="system-values-item"><a href="javascript:void(0);" data-toggle="tooltip" title="データ確認"><span class="d-inline-block user-avatar-block">#{{ $enterprise->employer->id }} {{ $enterprise->employer->full_name }}</span></a></p>
                            </li>
                            <li>
                                <p class="system-values-label">登録日時</p>
                                <p class="system-values-item">{{ $enterprise->created_at }}</p>
                            </li>
                            <li>
                                <p class="system-values-label">更新日時</p>
                                <p class="system-values-item">{{ $enterprise->updated_at }}</p>
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
                                {{ config('const.EMPLOYER_STATUS_2.' . $enterprise->employer->status) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">企業名</label>
                            <div class="col-sm-8">
                                {{ $enterprise->cname }} ({{ $enterprise->cname_katakana }})
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">住所</label>
                            <div class="col-sm-8">
                                〒 {{ $enterprise->postcode }}<br>
                                {{ $enterprise->prefecture }}<br>
                                {{ $enterprise->address }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">電話番号 (求職者公開)</label>
                            <div class="col-sm-8">
                                {{ $enterprise->full_phone }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">業種</label>
                            <div class="col-sm-8">
                                {{ $enterprise->industry }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">事業内容</label>
                            <div class="col-sm-8">
                                {!! nl2br(e($enterprise->description )) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">代表者名</label>
                            <div class="col-sm-8">
                                {{ $enterprise->ceo }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">設立</label>
                            <div class="col-sm-8">
                                {{ $enterprise->foundation }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">資本金</label>
                            <div class="col-sm-8">
                                {{ $enterprise->capital }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">従業員数</label>
                            <div class="col-sm-8">
                                {{ $enterprise->employee_number }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">ホームページ</label>
                            <div class="col-sm-8">
                                <a href="{{ $enterprise->website }}" target="_brank">{{ $enterprise->website }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">振込人名義</label>
                            <div class="col-sm-8">
                                {{ $enterprise->transfer_person_name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
