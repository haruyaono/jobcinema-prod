@extends('adminlte::page')

@section('title', 'JOB CiNEMA | お祝い金設定')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>お祝い金設定</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('reward.index') }}">お祝い金設定</a></li>
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
                        <a href="{{ route('reward.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('reward.store') }}" method="POST" accept-charset="UTF-8">
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
                                <label class="col-sm-2 text-sm-right">金額</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="amount" name="data[Reward][amount]" class="form-control" value="{{ old('data.Reward.amount') }}" placeholder="入力　金額" required><span class="mt-1 ml-2">円</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">カテゴリ</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <select class="custom-select" name="data[Reward][category_id]" required>
                                            <option value="">選択</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if(old('data.Reward.category_id')===(string) $category->id){{ 'selected' }}@endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">ラベル</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="label" name="data[Reward][label]" class="form-control" value="{{ old('data.Reward.label') }}" placeholder="入力　ラベル">
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
