@extends('adminlte::page')

@section('title', 'JOB CiNEMA | お祝い金管理')

@section('content_header')
<h1><i class="fas fa-home mr-2"></i>お祝い金管理</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item active">お祝い金管理</li>
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
                    <form action="{{ route('reward.index') }}" method="get">
                        <div class="row">
                            <div class="col-12">
                                <div class="fields-group">
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">応募者ID</label>
                                        <div class="col-xl-9">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <input type="text" class="form-control" placeholder="応募者ID" name="user_id" value="{{ $param['user_id'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">応募ID</label>
                                        <div class="col-xl-9">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <input type="text" class="form-control" placeholder="応募ID" name="apply_id" value="{{ $param['apply_id'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">申請日</label>
                                        <div class="input-group col-xl-9">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="created_at_start" placeholder="申請日" name="created_at[start]" value="{{ $param['created_at']['start'] ?? '' }}">
                                            <span class="input-group-text rounded-0 bg-white" style="border-left: 0; border-right: 0;">-</span>
                                            <input type="text" class="form-control" id="created_at_end" placeholder="申請日" name="created_at[end]" value="{{ $param['created_at']['end'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">ステータス</label>
                                        <div class="col-xl-9">
                                            <div class="input-group">
                                                <select class="form-control select-box" name="status">
                                                    <option value="">未選択</option>
                                                    @foreach(config('const.CONGRAT_PAYMENT_STATUS') as $key => $value)
                                                    <option value="{{ $key }}" {{ array_key_exists('status', $param) && isset($param['status']) && $param['status'] === (string) $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">金額</label>
                                        <div class="col-xl-9">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <input type="text" class="form-control" placeholder="金額" name="billing_amount" value="{{ $param['billing_amount'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-2 col-form-label">支払日</label>
                                        <div class="input-group col-xl-9">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="payment_date_start" placeholder="支払日" name="payment_date[start]" value="{{ $param['payment_date']['start'] ?? '' }}">
                                            <span class="input-group-text rounded-0 bg-white" style="border-left: 0; border-right: 0;">-</span>
                                            <input type="text" class="form-control" id="payment_date_end" placeholder="支払日" name="payment_date[end]" value="{{ $param['payment_date']['end'] ?? '' }}">
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
                                            <a href="{{ route('reward.index') }}" class="btn btn-secondary btn-sm"><i class="fa fa-undo"></i>&nbsp;&nbsp;リセット</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table id="tableReward" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="nosort">ID</th>
                            <th>申請日</th>
                            <th>ステータス</th>
                            <th>金額</th>
                            <th>支払日</th>
                            <th class="nosort">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$rewards->isEmpty())
                        @foreach($rewards as $reward)
                        <tr>
                            <td>{{ $reward->id }}</td>
                            <td>{{ $reward->created_at }}</td>
                            <td>{{ config('const.CONGRAT_PAYMENT_STATUS.' . $reward->status) }}</td>
                            <td>{{ $reward->custom_amount }}</td>
                            <td>{{ $reward->payment_date ? $reward->payment_date->format('Y-m-d H:i') : '未払い' }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('reward.show', $reward->id) }}">
                                    <i class="fas fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-info btn-sm" href="{{ route('reward.edit', $reward->id) }}">
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
        $('#payment_date_start').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja'
        }).on("changeDate", function(e) {
            $('#payment_date_end').datepicker('setStartDate', e.date);
        });
        $('#payment_date_end').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja'
        }).on("changeDate", function(e) {
            $('#payment_date_start').datepicker('setEndDate', e.date);
        });

        tableJobItem = $('#tableReward').DataTable({
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
