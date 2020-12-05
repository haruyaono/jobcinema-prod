@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 企業テーブル')

@section('content_header')
<h1><i class="fas fa-home mr-2"></i>企業テーブル</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item active">企業テーブル</li>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header with-border">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat filter-btn">フィルター</button>
                </div>
                <div class="mt-4 mb-3" id="filter-box">
                    <form action="{{ route('enterprise.index') }}" class="form-horizontal" method="get">
                        <div class="row form-inline">
                            <div class="col-md-12">
                                <div class="fields-group">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">企業ID</label>
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <input type="text" class="form-control" placeholder="企業ID" name="enterprise[id]" value="{{ $param['enterprise']['id'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">採用担当ID</label>
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <input type="text" class="form-control" placeholder="採用担当ID" name="employer[id]" value="{{ $param['employer']['id'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">企業名</label>
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <input type="text" class="form-control" placeholder="企業名" name="enterprise[cname]" value="{{ $param['enterprise']['cname'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">採用担当者名</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <div class="row">
                                                    <div class="col input-group-sm">
                                                        <input type="text" class="form-control" placeholder="採用担当 姓" name="employer[last_name]" value="{{ $param['employer']['last_name'] ?? '' }}">
                                                    </div>
                                                    <div class="col input-group-sm">
                                                        <input type="text" class="form-control" placeholder="採用担当 名" name="employer[first_name]" value="{{ $param['employer']['first_name'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">登録日</label>
                                        <div class="input-group col-sm-9">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="created_at_start" placeholder="作成日" name="enterprise[created_at][start]" value="{{ $param['enterprise']['created_at']['start'] ?? '' }}">
                                            <span class="input-group-text rounded-0 bg-white" style="border-left: 0; border-right: 0;">-</span>
                                            <input type="text" class="form-control" id="created_at_end" placeholder="作成日" name="enterprise[created_at][end]" value="{{ $param['enterprise']['created_at']['end'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> 更新日</label>
                                        <div class="input-group col-sm-9">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="updated_at_start" placeholder="更新日" name="enterprise[updated_at][start]" value="{{ $param['enterprise']['updated_at']['start'] ?? '' }}">
                                            <span class="input-group-text rounded-0 bg-white" style="border-left: 0; border-right: 0;">-</span>
                                            <input type="text" class="form-control" id="updated_at_end" placeholder="更新日" name="enterprise[updated_at][end]" value="{{ $param['enterprise']['updated_at']['end'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">ステータス</label>
                                        <div class="input-group col-sm-9">
                                            <select class="form-control select-box" name="employer[status]">
                                                <option value="">未選択</option>
                                                @foreach(config('const.EMPLOYER_STATUS_2') as $key => $value)
                                                <option value="{{ $key }}" {{ array_key_exists('employer', $param) && array_key_exists('status', $param['employer']) && isset($param['employer']['status']) && $param['employer']['status'] === (string) $key ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <div class="btn-group pull-left">
                                            <button class="btn btn-info submit btn-sm"><i class="fa fa-search"></i>&nbsp;&nbsp;サーチ</button>
                                        </div>
                                        <div class="btn-group pull-left " style="margin-left: 10px;">
                                            <a href="{{ route('enterprise.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-undo"></i>&nbsp;&nbsp;リセット</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table id="tableEnterprise" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ステータス</th>
                            <th class="nosort">企業名</th>
                            <th class="nosort">採用担当</th>
                            <th>登録日</th>
                            <th>更新日</th>
                            <th class="nosort">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$enterprises->isEmpty())
                        @foreach($enterprises as $enterprise)
                        <tr>
                            <td>{{ $enterprise->id }}</td>
                            <td>{{ config('const.EMPLOYER_STATUS_2.' . $enterprise->employer->status) }}</td>
                            <td>{{ $enterprise->cname }}</td>
                            <td>{{ $enterprise->employer->full_name }}</td>
                            <td>{{ $enterprise->created_at->toDateString() }}</td>
                            <td>{{ $enterprise->updated_at->toDateString() }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('enterprise.show', $enterprise->id) }}">
                                    <i class="fas fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-info btn-sm" href="{{ route('enterprise.edit', $enterprise->id) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <p>データがありません</p>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(function() {
        $('#created_at_start').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja'
        }).on("changeDate", function(e) {
            $('#created_at_end').datepicker('setStartDate', e.date);
        });
        $('#created_at_end').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja'
        }).on("changeDate", function(e) {
            $('#created_at_start').datepicker('setEndDate', e.date);
        });
        $('#updated_at_start').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja'
        }).on("changeDate", function(e) {
            $('#updated_at_end').datepicker('setStartDate', e.date);
        });
        $('#updated_at_end').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja'
        }).on("changeDate", function(e) {
            $('#updated_at_start').datepicker('setEndDate', e.date);
        });

        $('#tableEnterprise').DataTable({
            "paging": true,
            "searching": true,
            "scrollX": true,
            "ordering": true,
            "lengthMenu": [10, 20, 30, 40, 50, 100],
            "displayLength": 50,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "columnDefs": [{
                "targets": 'nosort',
                "orderable": false
            }]
        });

    });
</script>
@stop
