@extends('adminlte::page')

@section('title', 'JOB CiNEMA | ユーザーテーブル')

@section('content_header')
    <h1><i class="fas fa-home mr-2"></i>ユーザーテーブル</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item active">ユーザーテーブル</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tableEnterprise" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th class="nosort">ユーザー名</th>
                            <th class="nosort">ユーザー名(カナ)</th>
                            <th>登録日</th>
                            <th>更新日</th>
                            <th class="nosort">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$users->isEmpty())
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->last_name . ' ' . $user->first_name }}</td>
                                    <td>{{ $user->last_name_kana . ' ' . $user->first_name_kana }}</td>
                                    <td>{{ $user->created_at->toDateString() }}</td>
                                    <td>{{ $user->updated_at->toDateString() }}</td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm" href="{{ route('user.show', $user->id) }}">
                                            <i class="fas fa-eye">
                                            </i>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{ route('user.edit', $user->id) }}">
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
