@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 広告管理')

@section('content_header')
    <h1><i class="fas fa-home mr-2"></i>広告管理</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item active">広告管理</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header with-border">
                    <div class="btn-group float-right">
                        <a href="{{ route('ad_item.create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i><span class="hidden-xs">&nbsp;&nbsp;新規</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tableReward" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>広告企業ID</th>
                            <th>広告求人ID</th>
                            <th>画像ファイル</th>
                            <th>説明</th>
                            <th>料金</th>
                            <th>掲載</th>
                            <th>掲載期間</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$adItems->isEmpty())
                            @foreach($adItems as $adItem)
                                <tr>
                                    <td>{{ $adItem->id }}</td>
                                    <td><a href="/admin/data/enterprise/{{ $adItem->company_id }}">{{ $adItem->company_id }}</a></td>
                                    <td><a href="/admin/data/job_sheet/{{ $adItem->job_item_id }}">{{ $adItem->job_item_id }}</a></td>
                                    <td><img src="{{ $adItem->image_path }}" alt="{{ $adItem->description }}"/></td>
                                    <td>{{ $adItem->description }}</td>
                                    <td>{{ $adItem->price }}円</td>
                                    <td>@if($adItem->is_view)掲載中@else未掲載@endif</td>
                                    <td>{{ $adItem->started_at }}<br>~<br>{{ $adItem->ended_at }}</td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm" href="{{ route('ad_item.show', $adItem->id) }}">
                                            <i class="fas fa-eye">
                                            </i>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{ route('ad_item.edit', $adItem->id) }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm grid-row-delete" data-id="{{ $adItem->id }}" data-toggle="tooltip" title="" data-original-title="削除">
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
                deleteItem('/admin/data/ad_item/', id, '/admin/data/ad_item');
            });

        });
    </script>
@stop