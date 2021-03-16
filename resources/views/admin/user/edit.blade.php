@extends('adminlte::page')

@section('title', 'JOB CiNEMA | ユーザーテーブル')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>ユーザーテーブル</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">ユーザーテーブル</a></li>
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
                            <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-primary" title="編集">
                                <i class="fa fa-edit"></i><span class="hidden-xs"> 表示</span>
                            </a>
                        </div>
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-default" title="一覧">
                                <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                    <label class="col-sm-2 text-sm-right">氏名</label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">姓</span>
                                            </div>
                                            <input name="data[user][last_name]" class="form-control" placeholder="入力 氏名 姓" value="{{ old('data.user.last_name') ?: $user->last_name }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">名</span>
                                            </div>
                                            <input name="data[user][first_name]" class="form-control" placeholder="入力 氏名 名" value="{{ old('data.user.first_name') ?: $user->first_name }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">氏名カナ</label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">姓</span>
                                            </div>
                                            <input name="data[user][last_name_kana]" class="form-control" placeholder="入力 氏名 姓" value="{{ old('data.user.last_name_kana') ?: $user->last_name_kana }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">名</span>
                                            </div>
                                            <input name="data[user][first_name_kana]" class="form-control" placeholder="入力 氏名 名" value="{{ old('data.user.first_name_kana') ?: $user->first_name_kana }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">年齢</label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][age]" class="form-control" placeholder="入力 年齢" value="{{ old('data.profile.age') ?: $user->profile->age }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">性別</label>
                                    <div class="col-sm-4">
                                        <select class="custom-select" name="data[profile][gender]">
                                            <option value="男性" @if(old('data.profile.gender') === "男性" || $user->profile->gender == "男性") selected @endif>男性</option>
                                            <option value="女性" @if(old('data.profile.gender') === "女性" || $user->profile->gender == "女性") selected @endif>女性</option>
                                            <option value="その他" @if(old('data.profile.gender') === "その他" || $user->profile->gender == "その他") selected @endif>その他</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">メールアドレス</label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[user][email]" class="form-control" placeholder="入力 メールアドレス" value="{{ old('data.user.email') ?: $user->email }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">電話番号</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][phone1]" class="form-control" placeholder="入力 電話番号" value="{{ old('data.profile.phone1') ?: $user->profile->phone1 }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][phone2]" class="form-control" placeholder="入力 電話番号" value="{{ old('data.profile.phone2') ?: $user->profile->phone2 }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][phone3]" class="form-control" placeholder="入力 電話番号" value="{{ old('data.profile.phone3') ?: $user->profile->phone3 }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">最終学歴</label>
                                    <div class="col-sm-4">
                                        <select class="custom-select" name="data[profile][final_education]">
                                            @foreach($final_education as $value)
                                            <option value="{{ $value }}" @if(old('data.profile.final_education')== $value || $user->profile->final_education==$value) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">職業</label>
                                    <div class="col-sm-4">
                                        <select class="custom-select" name="data[profile][occupation]">
                                            @foreach($occupation as $value)
                                            <option value="{{ $value }}" @if(old('data.profile.occupation')== $value || $user->profile->occupation==$value) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">郵便番号</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][postcode]" class="form-control" placeholder="入力 郵便番号" value="{{ old('data.profile.postcode') ?: $user->profile->postcode }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">都道府県</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][prefecture]" class="form-control" placeholder="入力 都道府県" value="{{ old('data.profile.prefecture') ?: $user->profile->prefecture }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">市区町村</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][city]" class="form-control" placeholder="入力 市区町村" value="{{ old('data.profile.city') ?: $user->profile->city }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">丁目番地</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][address]" class="form-control" placeholder="入力 丁目番地" value="{{ old('data.profile.address') ?: $user->profile->address }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">建物名</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][building]" class="form-control" placeholder="入力 建物名" value="{{ old('data.profile.building') ?: $user->profile->building }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">銀行名</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][bank_name]" class="form-control" placeholder="入力 銀行名" value="{{ old('data.profile.bank_name') ?: $user->profile->bank_name }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">支店名</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][branch_name]" class="form-control" placeholder="入力 支店名" value="{{ old('data.profile.branch_name') ?: $user->profile->branch_name }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">口座タイプ</label>
                                    <div class="col-sm-8">
                                        <select class="custom-select" name="data[profile][account_type]">
                                            <option value="普通" @if(old('data.profile.account_type')== "普通" || $user->profile->account_type=="普通") selected @endif>普通</option>
                                            <option value="当座" @if(old('data.profile.account_type')== "当座" || $user->profile->account_type=="当座") selected @endif>当座</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">口座番号</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][account_bank]" class="form-control" placeholder="入力 口座番号" value="{{ old('data.profile.account_bank') ?: $user->profile->account_bank }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">口座名</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                            <input name="data[profile][account_name]" class="form-control" placeholder="入力 口座名" value="{{ old('data.profile.account_name') ?: $user->profile->account_name }}">
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
