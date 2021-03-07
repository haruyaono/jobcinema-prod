@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 応募管理')

@section('content_header')
<h1><i class="fas fa-home mr-2"></i>応募管理</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item active">応募管理</li>
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
                    <form action="{{ route('application.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fields-group">
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">ID</label>
                                        <div class="col-xl-9">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <input type="text" class="form-control id" placeholder="ID" name="id" value="{{ $param['id'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">応募日</label>
                                        <div class="input-group col-xl-9">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="created_at_start" placeholder="応募日" name="created_at[start]" value="{{ $param['created_at']['start'] ?? '' }}">
                                            <span class="input-group-text rounded-0 bg-white" style="border-left: 0; border-right: 0;">-</span>
                                            <input type="text" class="form-control" id="created_at_end" placeholder="応募日" name="created_at[end]" value="{{ $param['created_at']['end'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">採用ステータス</label>
                                        <div class="col-xl-9">
                                            <div class="input-group mb-3">
                                                <label class="col-form-label font-weight-normal mr-2">求職者</label>
                                                <select class="form-control select-box" name="s_recruit_status">
                                                    <option value="">未選択</option>
                                                    @foreach(config('const.RECRUITMENT_STATUS') as $key => $value)
                                                    <option value="{{ $key }}" {{ array_key_exists('s_recruit_status', $param) && isset($param['s_recruit_status']) && $param['s_recruit_status'] === (string) $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="input-group">
                                                <label class="col-form-label font-weight-normal mr-2">採用企業</label>
                                                <select class="form-control select-box" name="e_recruit_status">
                                                    <option value="">未選択</option>
                                                    @foreach(config('const.RECRUITMENT_STATUS') as $key => $value)
                                                    <option value="{{ $key }}" {{ array_key_exists('e_recruit_status', $param) && isset($param['e_recruit_status']) && $param['e_recruit_status'] === (string) $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">採用フラグ</label>
                                        <div class="input-group col-xl-9">
                                            <div class="input-group input-group-sm">
                                                <span class="form-check form-check-inline">
                                                    <input type="radio" class="recruit_status_flag" name="recruit_status_flag" id="recruit_status_flag_all" value="" {{ !isset($param['recruit_status_flag']) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="recruit_status_flag_all">&nbsp;全て&nbsp;&nbsp</label>
                                                </span>
                                                <span class="form-check form-check-inline">
                                                    <input type="radio" class="recruit_status_flag" name="recruit_status_flag" id="recruit_status_flag_no" value="1" {{ isset($param['recruit_status_flag']) && $param['recruit_status_flag'] == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="recruit_status_flag_no">&nbsp;一致&nbsp;&nbsp</label>
                                                </span>
                                                <span class="form-check form-check-inline">
                                                    <input type="radio" class="recruit_status_flag" name="recruit_status_flag" id="recruit_status_flag_yes" value="0" {{ isset($param['recruit_status_flag']) && $param['recruit_status_flag'] == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="recruit_status_flag_yes">&nbsp;不一致&nbsp;&nbsp</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fields-group">
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">初出社日</label>
                                        <div class="input-group col-xl-9">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="e_first_attendance_at_start" placeholder="初出社日" name="e_first_attendance_at[start]" value="{{ $param['e_first_attendance_at']['start'] ?? '' }}">
                                            <span class="input-group-text rounded-0 bg-white" style="border-left: 0; border-right: 0;">-</span>
                                            <input type="text" class="form-control" id="e_first_attendance_at_end" placeholder="初出社日" name="e_first_attendance_at[end]" value="{{ $param['e_first_attendance_at']['end'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">初出社日フラグ</label>
                                        <div class="input-group col-xl-9">
                                            <div class="input-group input-group-sm">
                                                <span class="form-check form-check-inline">
                                                    <input type="radio" class="first_attendance_flag" name="first_attendance_flag" id="first_attendance_flag_all" value="" {{ !isset($param['first_attendance_flag']) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="first_attendance_flag_all">&nbsp;全て&nbsp;&nbsp</label>
                                                </span>
                                                <span class="form-check form-check-inline">
                                                    <input type="radio" class="first_attendance_flag" name="first_attendance_flag" id="first_attendance_flag_no" value="1" {{ isset($param['first_attendance_flag']) && $param['first_attendance_flag'] == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="first_attendance_flag_no">&nbsp;一致&nbsp;&nbsp</label>
                                                </span>
                                                <span class="form-check form-check-inline">
                                                    <input type="radio" class="first_attendance_flag" name="first_attendance_flag" id="first_attendance_flag_yes" value="0" {{ isset($param['first_attendance_flag']) && $param['first_attendance_flag'] == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="first_attendance_flag_yes">&nbsp;不一致&nbsp;&nbsp</label>
                                                </span>
                                            </div>
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
                                            <a href="{{ route('application.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-undo"></i>&nbsp;&nbsp;リセット</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table id="tableApplication" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>応募日</th>
                            <th>応募者</th>
                            <th>応募求人</th>
                            <th>応募者ステータス</th>
                            <th class>企業ステータス</th>
                            <th>初出社日(応募者)</th>
                            <th>初出社日(企業)</th>
                            <th>採用確定日</th>
                            <th>面接日</th>
                            <th class="nosort">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$applies->isEmpty())
                        @foreach($applies as $apply)
                        <tr>
                            <td>{{ $apply->id }}</td>
                            <td>{{ $apply->created_at->toDateString() }}</td>
                            <td>{{ $apply->detail->full_name }}</td>
                            <td>{{ $apply->jobitem->id }}</td>
                            <td>{{ config('const.RECRUITMENT_STATUS.' . $apply->s_recruit_status) }}</td>
                            <td>{{ config('const.RECRUITMENT_STATUS.' . $apply->e_recruit_status) }}</td>
                            <td>{{ $apply->s_first_attendance }}</td>
                            <td>{{ $apply->e_first_attendance }}</td>
                            <td>{{ $apply->recruit_confirm ?: '未確定' }}</td>
                            <td>{{ $apply->interview ?: '未確定' }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('application.show', $apply->id) }}">
                                    <i class="fas fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-info btn-sm" href="{{ route('application.edit', $apply->id) }}">
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
        $('#e_first_attendance_at_start').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja'
        }).on("changeDate", function(e) {
            $('#updated_at_end').datepicker('setStartDate', e.date);
        });
        $('#e_first_attendance_at_end').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja'
        }).on("changeDate", function(e) {
            $('#updated_at_start').datepicker('setEndDate', e.date);
        });

        tableJobItem = $('#tableApplication').DataTable({
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
