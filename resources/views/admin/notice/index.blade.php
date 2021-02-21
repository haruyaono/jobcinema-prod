@extends('adminlte::page')

@section('title', 'JOB CiNEMA | お知らせ管理')

@section('content_header')
    <h1><i class="fas fa-home mr-2"></i>お知らせ管理</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item active">お知らせ管理</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header with-border">
                    <div class="btn-group float-right">
                        <a href="{{ route('notice.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i><span class="hidden-xs">&nbsp;&nbsp;新規</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tableReward" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>件名</th>
                            <th>本文</th>
                            <th>対象</th>
                            <th>配信</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$notices->isEmpty())
                            @foreach($notices as $notice)
                                <tr>
                                    <td>{{ $notice->id }}</td>
                                    <td>{{ $notice->subject }}</td>
                                    <td><p style="white-space: pre-wrap;">{{ $notice->content }}</p></td>
                                    <td>{{ $notice->target }}</td>
                                    <td>@if($notice->is_delivered)配信中@else未配信@endif</td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm" href="{{ route('notice.show', $notice->id) }}">
                                            <i class="fas fa-eye">
                                            </i>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{ route('notice.edit', $notice->id) }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm grid-row-delete" data-id="{{ $notice->id }}" data-toggle="tooltip" title="" data-original-title="削除">
                                            <i class="fa fa-trash"></i>
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
            $('#tableReward').DataTable({
                "paging": true,
                "searching": true,
                "scrollX": true,
                "ordering": false,
                "lengthMenu": [10, 20, 30, 40, 50, 100],
                "displayLength": 10,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                    "targets": 'nosort',
                    "orderable": false
                }]
            });

            $('.grid-row-delete').unbind('click').click(function() {
                let id = $(this).data('id');
                deleteItem('/admin/data/notice/', id, '/admin/data/notice');
            });

        });
    </script>
@stop