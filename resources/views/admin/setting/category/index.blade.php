@extends('adminlte::page')

@section('title', 'JOB CiNEMA | カテゴリ設定')

@section('content_header')
<h1><i class="fas fa-home mr-2"></i>カテゴリ設定</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item active">カテゴリ設定</li>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header with-border">
                <div class="btn-group float-right">
                    <a href="{{ route('category.create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i><span class="hidden-xs">&nbsp;&nbsp;新規</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="tableCategory" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>名前</th>
                            <th>並び順</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$categories->isEmpty())
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td class="font-weight-bold">{{ $category->name }}</td>
                            <td></td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('category.show', $category->id) }}">
                                    <i class="fas fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-info btn-sm" href="{{ route('category.edit', $category->id) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm grid-row-delete" data-id="{{ $category->id }}" data-toggle="tooltip" title="" data-original-title="削除">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @if($category->children)
                        @foreach($category->children->sortBy('sort') as $children)
                        <tr>
                            <td>{{ $children->id }}</td>
                            <td>ー {{ $children->name }}</td>
                            <td>{{ $children->children->isEmpty() ? $children->sort : '' }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('category.show', $children->id) }}">
                                    <i class="fas fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-info btn-sm" href="{{ route('category.edit', $children->id) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm grid-row-delete" data-id="{{ $children->id }}" data-toggle="tooltip" title="" data-original-title="削除">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @if($children->children)
                        @foreach($children->children->sortBy('sort') as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>ーー {{ $c->name }}</td>
                            <td>{{ $c->children->isEmpty() ? $c->sort : '' }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('category.show', $c->id) }}">
                                    <i class="fas fa-eye">
                                    </i>
                                </a>
                                <a class="btn btn-info btn-sm" href="{{ route('category.edit', $c->id) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm grid-row-delete" data-id="{{ $c->id }}" data-toggle="tooltip" title="" data-original-title="削除">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        @endforeach
                        @endif
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
        $('#tableCategory').DataTable({
            "paging": true,
            "searching": true,
            "scrollX": true,
            "ordering": false,
            "lengthMenu": [50, 100, 200, 300],
            "displayLength": 100,
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
            deleteItem('/admin/setting/category/', id, '/admin/setting/category');
        });

    });
</script>
@stop
