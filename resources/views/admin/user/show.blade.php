@extends('adminlte::page')

@section('title', 'JOB CiNEMA | ユーザーテーブル')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>ユーザーテーブル</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item"><a href="{{ route('job_sheet.index') }}">ユーザーテーブル</a></li>
    <li class="breadcrumb-item active">詳細</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">詳細</h3>
                    <div class="card-tools">
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-default" title="一覧">
                                <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                            </a>
                        </div>
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-primary" title="編集">
                                <i class="fa fa-edit"></i><span class="hidden-xs"> 編集</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="system-values">
                            <div class="system-values-flows">
                            </div>
                            <ul class="system-values-list">
                                <li>
                                    <p class="system-values-label">ID</p>
                                    <p class="system-values-item">{{ $user->id }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">ユーザー名</p>
                                    <p class="system-values-item">{{ $user->last_name }} {{ $user->first_name }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">登録日時</p>
                                    <p class="system-values-item">{{ $user->created_at }}</p>
                                </li>
                                <li>
                                    <p class="system-values-label">更新日時</p>
                                    <p class="system-values-item">{{ $user->updated_at }}</p>
                                </li>
                            </ul>
                        </div>
                        <hr>
                    </div>
                    <div class="body-box">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">氏名</label>
                                <div class="col-sm-8">
                                    {{ $user->last_name }} {{ $user->first_name }} ({{ $user->last_name_kana }} {{ $user->first_name_kana }})
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">年齢</label>
                                <div class="col-sm-8">
                                    {{ $user->profile->age }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">性別</label>
                                <div class="col-sm-8">
                                    {{ $user->profile->gender }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">メールアドレス</label>
                                <div class="col-sm-8">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">電話番号</label>
                                <div class="col-sm-8">
                                    {{ $user->profile->phone1 }}-{{ $user->profile->phone2 }}-{{ $user->profile->phone3 }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">最終学歴</label>
                                <div class="col-sm-8">
                                    {{ $user->profile->final_education }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">職業</label>
                                <div class="col-sm-8">
                                    {{ $user->profile->occupation }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">住所</label>
                                <div class="col-sm-8">
                                    〒 {{ $user->profile->postcode }}<br>
                                    {{ $user->profile->prefecture }}<br>
                                    {{ $user->profile->city }} {{ $user->profile->address }}<br>
                                    {{ $user->profile->building }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">口座情報</label>
                                <div class="col-sm-8">
                                    {{ $user->profile->bank_name }} ({{ $user->profile->bank_code }})<br>
                                    {{ $user->profile->branch_name }} ({{ $user->profile->branch_code }})<br>
                                    {{ $user->profile->account_name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
