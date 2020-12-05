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
                <h3 class="card-title">作成</h3>
                <div class="card-tools">
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('category.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('category.store') }}" method="POST" accept-charset="UTF-8">
                    @csrf
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
                                        <input type="text" id="amount" name="data[Category][name]" class="form-control" value="{{ old('data.Category.name') }}" placeholder="入力　カテゴリ名" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">親カテゴリ</label>
                                <div class="col-sm-8">
                                    <div>
                                        <select class="custom-select parent" name="data[Category][parent_id]" required>
                                            <option value="">選択</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" class="{{ $category->slug == 'salary' ? 'salary' : '' }}" @if(old('data.Category.parent_id')===(string) $category->id){{ 'selected' }}@endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <select class="custom-select mt-2 children" name="data[Category][sub_parent_id]">
                                            <option value="">選択</option>
                                            @foreach($categories->where('slug', 'salary')->first()->children as $category)
                                            <option value="{{ $category->id }}" @if(old('data.Category.sub_parent_id')===(string) $category->id){{ 'selected' }}@endif data-val="{{ $category->parent->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" value="{{ $categories->where('slug', 'salary')->first()->id }}" id="parent_salary_id">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">ソート</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="label" name="data[Category][sort]" class="form-control" value="{{ old('data.Category.sort') }}" placeholder="入力　ソート">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8 text-right">
                                <div class="btn-group">
                                    <button id="admin-submit" type="submit" class="btn btn-primary">作成</button>
                                </div>
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
        let $parent = $('.parent');
        let parentSalaryId = $('#parent_salary_id').val();
        let $children = $('.children');
        let isSalary = false;

        if ($parent.val() == parentSalaryId) isSalary = true;

        $('.parent').change(function() {
            let val1 = $(this).val();
            $children.find('option').each(function() {
                let val2 = $(this).data('val');
                isSalary = true;
                if (val1 != val2) {
                    $(this).attr('selected', false)
                    isSalary = false;
                }
            });

            if (isSalary) {
                $children.show();
                $children.prop('required', true);
            } else {
                $children.hide();
                $children.prop('required', false);
            }

        });
        if (isSalary) {
            $children.show();
            $children.prop('required', true);
        } else {
            $children.hide();
            $children.prop('required', false);
        }
    });
</script>
@stop
