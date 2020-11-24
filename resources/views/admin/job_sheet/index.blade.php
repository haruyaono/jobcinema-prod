@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 求人票テーブル')

@section('content_header')
<h1><i class="fas fa-home mr-2"></i>求人票テーブル</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item active">求人票テーブル</li>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header with-border">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-flat filter-btn">フィルター</button>
                    <!-- <button type="button" class="btn btn-primary btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                        <span class="sr-only">ドロップダウン</span>
                        <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-1px, -3px, 0px);">
                            <a class="dropdown-item" href="#">削除済みデータ</a>
                        </div>
                    </button> -->
                </div>
                <div class="mt-4 mb-3" id="filter-box">
                    <form action="{{ route('job_sheet.index') }}" class="form-horizontal" pjax-container="" method="get">
                        <div class="row form-inline">
                            <div class="col-md-12">
                                <div class="fields-group">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">ID</label>
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <input type="text" class="form-control id" placeholder="ID" name="id" value="{{ $param['id'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">作成日</label>
                                        <div class="input-group col-sm-9">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="created_at_start" placeholder="作成日" name="created_at[start]" value="{{ $param['created_at']['start'] ?? '' }}">
                                            <span class="input-group-text rounded-0 bg-white" style="border-left: 0; border-right: 0;">-</span>
                                            <input type="text" class="form-control" id="created_at_end" placeholder="作成日" name="created_at[end]" value="{{ $param['created_at']['end'] ?? '' }}">
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
                                            <input type="text" class="form-control" id="updated_at_start" placeholder="更新日" name="updated_at[start]" value="{{ $param['updated_at']['start'] ?? '' }}">
                                            <span class="input-group-text rounded-0 bg-white" style="border-left: 0; border-right: 0;">-</span>
                                            <input type="text" class="form-control" id="updated_at_end" placeholder="更新日" name="updated_at[end]" value="{{ $param['updated_at']['end'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">ステータス</label>
                                        <div class="input-group col-sm-9">
                                            <select class="form-control select-box" name="status">
                                                <option value="">未選択</option>
                                                @foreach(config('const.EMP_JOB_STATUS') as $key => $value)
                                                <option value="{{ $key }}" {{ array_key_exists('status', $param) && $param['status'] && $param['status'] === (string) $key ? 'selected' : '' }}>{{ $value }}</option>
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
                                            <a href="{{ route('job_sheet.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-undo"></i>&nbsp;&nbsp;リセット</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table id="tableJobItem" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ステータス</th>
                            <th class="nosort">企業名</th>
                            <th>作成日</th>
                            <th>更新日</th>
                            <th class="nosort">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$jobitems->isEmpty())
                        @foreach($jobitems as $jobitem)
                        <tr>
                            <td>{{ $jobitem->id }}</td>
                            <td>{{ config('const.EMP_JOB_STATUS.' . $jobitem->status) }}</td>
                            <td>{{ $jobitem->company->cname }}</td>
                            <td>{{ $jobitem->created_at->toDateString() }}</td>
                            <td>{{ $jobitem->updated_at->toDateString() }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('job_sheet.show', $jobitem) }}">
                                    <i class="fas fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-info btn-sm" href="{{ route('job_sheet.edit', $jobitem->id) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                                <!-- <a class="btn btn-danger btn-sm" href="#">
                                    <i class="fas fa-trash">
                                    </i>
                                </a> -->
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

        tableJobItem = $('#tableJobItem').DataTable({
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
        let target = $('.filter-btn');
        target.unbind('click');
        target.click(function(e) {
            if ($('#filter-box').is(':visible')) {
                $('#filter-box').addClass('d-none');
            } else {
                if (''.length > 0) {
                    if (target.attr('disabled')) {
                        return;
                    }
                    if (target.hasClass('loaded')) {
                        $('#filter-box').removeClass('d-none');
                        return;
                    }
                    var spinner = target.attr('disabled', true).data('loading-text');
                    target.append(spinner);
                    $.ajax({
                        url: '',
                        type: "GET",
                        contentType: 'application/json;charset=utf-8',
                        success: function(data) {
                            $('#filter-box').html($(data.html).children('form'));
                            eval(data.script);
                            target.attr('disabled', false).addClass('loaded');
                            target.find('.fa-spinner').remove();
                            $('#filter-box').removeClass('d-none');
                        }
                    });
                } else {
                    $('#filter-box').removeClass('d-none');
                }
            }
        });

        $('#select-box').select2({
            width: 'resolve'
        });

    });
</script>
@stop
