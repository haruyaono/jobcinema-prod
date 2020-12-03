@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 採用報酬設定')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>採用報酬設定</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('recruit_reward.index') }}">採用報酬設定</a></li>
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
                        <a href="{{ route('recruit_reward.show', $reward->id) }}" class="btn btn-sm btn-primary" title="編集">
                            <i class="fa fa-edit"></i><span class="hidden-xs"> 表示</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('recruit_reward.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger {{ $reward->id }}-delete" title="削除">
                            <i class="fa fa-trash"></i><span class="hidden-xs"> 削除</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('recruit_reward.update', $reward->id) }}" method="POST" accept-charset="UTF-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="data[RecruitReward][id]" value="{{ $reward->id }}">
                    <div class="form-group">
                        <div class="system-values">
                            <div class="system-values-flows">
                            </div>
                            <ul class="system-values-list">
                                <li>
                                    <p class="system-values-label">ID</p>
                                    <p class="system-values-item">{{ $reward->id }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">作成日時</p>
                                    <p class="system-values-item">{{ $reward->created_at }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">更新日時</p>
                                    <p class="system-values-item">{{ $reward->created_at }}</p>
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
                                <label class="col-sm-2 text-sm-right">金額</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="amount" name="data[RecruitReward][amount]" class="form-control" value="@if(old('data.RecruitReward.amount')){{ old('data.RecruitReward.amount') }}@else{{ $reward->amount ?: '' }}@endif" placeholder="入力　金額" required><span class="mt-1 ml-2">円</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">カテゴリ</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <select class="custom-select" name="data[RecruitReward][category_id]" required>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if(old('data.RecruitReward.category_id')===(string) $category->id){{ 'selected' }}@else{{ !old('data.RecruitReward.category_id') && old('data.RecruitReward.category_id') !== '0' && $category->id === $reward->category_id ? 'selected' : ''}}@endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">ラベル</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="label" name="data[RecruitReward][label]" class="form-control" value="@if(old('data.RewRecruitRewardard.label')){{ old('data.RecruitReward.label') }}@else{{ $reward->label ?: '' }}@endif" placeholder="入力　ラベル">
                                </div>
                            </div>
                        </div>
                    </div>
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
        $('.{{$reward->id}}-delete').click(function(event) {
            deleteItem('/admin/setting/recruit_reward/', '{{$reward->id}}', '/admin/setting/recruit_reward');
        });

    });
</script>
@stop
