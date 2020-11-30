@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 企業テーブル')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>企業テーブル</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('enterprise.index') }}">企業テーブル</a></li>
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
                        <a href="{{ route('enterprise.show', $enterprise->id) }}" class="btn btn-sm btn-primary" title="編集">
                            <i class="fa fa-edit"></i><span class="hidden-xs"> 表示</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('enterprise.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('enterprise.update', $enterprise->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                                    <p class="system-values-item"><a href="javascript:void(0);" data-toggle="tooltip" title="データ確認"><span class="d-inline-block">#{{ $enterprise->id }} {{ $enterprise->cname }}</span></a></p>
                                </li>
                                <li>
                                    <p class="system-values-label">採用担当</p>
                                    <p class="system-values-item"><a href="javascript:void(0);" data-toggle="tooltip" title="データ確認"><span class="d-inline-block">#{{ $enterprise->employer->id }} {{ $enterprise->employer->full_name }}</span></a></p>
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
                            <div class="row align-items-center">
                                <label class="col-sm-2 text-sm-right">ステータス</label>
                                <div class="col-sm-8">
                                    <select class="custom-select" name="data[Enterprise][status]">
                                        @foreach(config('const.EMPLOYER_STATUS_2') as $key => $value)
                                        <option value="{{ $key }}" @if(old('data.Enterprise.status')===(string) $key){{ 'selected' }}@else{{ $key === $enterprise->employer->status ? 'selected' : ''}}@endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">企業名</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input name="data[Enterprise][cname]" class="form-control" placeholder="入力 企業名" value="{{ old('data.Enterprise.cname') ?: $enterprise->cname }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">企業名（カタカナ）</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input name="data[Enterprise][cname_katakana]" class="form-control" placeholder="入力 企業名（カタカナ）" value="{{ old('data.Enterprise.cname_katakana') ?: $enterprise->cname_katakana }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">住所</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-row align-items-center">
                                            <span class="mr-2">〒</span>
                                            <input size="18" class="form-control col-4 col-sm-2" type="text" name="data[Enterprise][postcode01]" maxlength="3" value="@if(old('data.Enterprise.postcode01')){{ old('data.Enterprise.postcode01') }}@else{{ array_key_exists(0, $postcode) ? $postcode[0] : '' }}@endif" placeholder="000">
                                            <span class="mx-2">-</span>
                                            <input size="28" class="form-control col-6 col-sm-3" type="text" name="data[Enterprise][postcode02]" maxlength="4" value="@if(old('data.Enterprise.postcode02')){{ old('data.Enterprise.postcode02') }}@else{{ array_key_exists(1, $postcode) ? $postcode[1] : '' }}@endif" placeholder="0000" onKeyUp="AjaxZip3.zip2addr('data[Enterprise][postcode01]','data[Enterprise][postcode02]','data[Enterprise][prefecture]','data[Enterprise][address]');">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="data[Enterprise][prefecture]" value="{{ old('data.Enterprise.prefecture') ?: $enterprise->prefecture }}" class="form-control col-12 col-sm-3" placeholder="北海道">
                                    </div>
                                    <div class="form-group">
                                        <input name="data[Enterprise][address]" value="{{ old('data.Enterprise.address') ?: $enterprise->address }}" class="form-control col-12 col-sm-12" placeholder="釧路市 〇〇丁目 〇〇-〇〇">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">電話番号</label>
                                <div class="col-sm-8">
                                    <div class="form-row align-items-center">
                                        <input class="form-control col-3" maxlength="5" type="text" name="data[Enterprise][phone1]" value="{{ old('data.Enterprise.phone1') ?: $enterprise->phone1 }}">
                                        &nbsp;-&nbsp;
                                        <input class="form-control col-3" maxlength="4" type="text" name="data[Enterprise][phone2]" value="{{ old('data.Enterprise.phone2') ?: $enterprise->phone2 }}">
                                        &nbsp;-&nbsp;
                                        <input class="form-control col-3" maxlength="4" type="text" name="data[Enterprise][phone3]" value="{{ old('data.Enterprise.phone3') ?: $enterprise->phone3 }}">
                                    </div>
                                    <p class="mt-2">※求職者に公開されます</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">業種</label>
                                <div class="col-sm-8">
                                    <select class="custom-select" name="data[Enterprise][industry]">
                                        @foreach($industries as $value)
                                        <option value="{{ $value }}" @if(old('data.Enterprise.industry')==$value){{ 'selected' }}@else{{ $value == $enterprise->industry ? 'selected' : ''}}@endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">事業内容</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[Enterprise][description]" class="form-control" placeholder="入力 事業内容">{{ old('data.Enterprise.description') ?: $enterprise->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">代表者名</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input name="data[Enterprise][ceo]" class="form-control" placeholder="入力 代表者名" value="{{ old('data.Enterprise.ceo') ?: $enterprise->ceo }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">設立</label>
                                <div class="col-sm-8">
                                    <div class="form-row align-items-center">
                                        <span>西暦</span>
                                        <input type="text" maxlength="4" class="form-control col-md-2 mx-2" name="data[Enterprise][f_year]" value="@if(old('data.Enterprise.f_year')){{ old('data.Enterprise.f_year') }}@else{{ array_key_exists(0, $foundation) ? $foundation[0] : '' }}@endif">
                                        <span>年</span>
                                        <select class="mx-2 custom-select col-2" name="data[Enterprise][f_month]">
                                            <option value="">---</option>
                                            @foreach(range(1, 12) as $fMonth)
                                            {{ var_dump(old('data.Enterprise.f_month')==(string) $fMonth) }}
                                            <option value="{{ $fMonth }}" @if(old('data.Enterprise.f_month')==(string) $fMonth){{ 'selected' }}@else{{ old('data.Enterprise.f_month') == null && array_key_exists(1, $foundation) ? 'selected' : '' }}@endif>{{ $fMonth }}</option>
                                            @endforeach
                                        </select>
                                        <span>月</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">資本金</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input name="data[Enterprise][capital]" class="form-control" placeholder="入力 資本金" value="{{ old('data.Enterprise.capital') ?: $enterprise->capital }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">従業員数</label>
                                <div class="col-sm-8">
                                    <select class="custom-select" name="data[Enterprise][employee_number]">
                                        <option value="">---</option>
                                        @foreach($employeeNumbers as $value)
                                        <option value="{{ $value }}" @if(old('data.Enterprise.employee_number')==$value){{ 'selected' }}@else{{ $value == $enterprise->employee_number ? 'selected' : ''}}@endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">ホームページ</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input name="data[Enterprise][website]" class="form-control" placeholder="入力 ホームページ" value="{{ old('data.Enterprise.website') ?: $enterprise->website }}">
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
