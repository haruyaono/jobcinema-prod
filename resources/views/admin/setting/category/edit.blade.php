@extends('adminlte::page')

@section('title', 'JOB CiNEMA | カテゴリ設定')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>カテゴリ設定</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('category.index') }}">カテゴリ設定</a></li>
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
                        <a href="{{ route('category.show', $category->id) }}" class="btn btn-sm btn-primary" title="編集">
                            <i class="fa fa-edit"></i><span class="hidden-xs"> 表示</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('category.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger {{ $category->id }}-delete" title="削除">
                            <i class="fa fa-trash"></i><span class="hidden-xs"> 削除</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('category.update', $category->id) }}" method="POST" accept-charset="UTF-8">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <div class="system-values">
                            <div class="system-values-flows">
                            </div>
                            <ul class="system-values-list">
                                <li>
                                    <p class="system-values-label">ID</p>
                                    <p class="system-values-item">{{ $category->id }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">作成日時</p>
                                    <p class="system-values-item">{{ $category->created_at }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">更新日時</p>
                                    <p class="system-values-item">{{ $category->created_at }}</p>
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
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">カテゴリ名</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="name" name="data[Category][name]" class="form-control" value="@if(old('data.Category.name')){{ old('data.Category.name') }}@else{{ $category->name ?: '' }}@endif" placeholder="入力　カテゴリ名" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">親カテゴリ</label>
                                <div class="col-sm-8">
                                    <div>
                                        @if($category->ancestors->isEmpty())
                                        なし
                                        @else
                                        {{ $category->parent->name }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($category->children->isEmpty())
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">ソート</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="label" name="data[Category][sort]" class="form-control" value="@if(old('data.Category.sort')){{ old('data.Category.sort') }}@else{{ $category->sort ?: '' }}@endif" placeholder="入力　ソート">
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="data[Category][sort]" class="form-control" value="0">
                    @endif
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

@section('js')
<script>
    $(function() {
        $('.{{$category->id}}-delete').click(function(event) {
            deleteItem('/admin/setting/category/', '{{$category->id}}', '/admin/setting/category');
        });
    });
</script>
@stop
