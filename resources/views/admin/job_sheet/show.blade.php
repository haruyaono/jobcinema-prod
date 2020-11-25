@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 求人票テーブル')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>求人票テーブル</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('job_sheet.index') }}">求人票テーブル</a></li>
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
                        <a href="{{ route('job_sheet.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('job_sheet.edit', $jobitem->id) }}" class="btn btn-sm btn-primary" title="編集">
                            <i class="fa fa-edit"></i><span class="hidden-xs"> 編集</span>
                        </a>
                    </div>
                    <!-- <div class="btn-group" style="margin-right: 5px">
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger 5fba2c4c996fa-delete" title="削除">
                            <i class="fa fa-trash"></i><span class="hidden-xs"> 削除</span>
                        </a>
                    </div> -->
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
                                <p class="system-values-item">{{ $jobitem->id }}</p>
                            </li>
                            <li>
                                <p class="system-values-label">企業</p>
                                <p class="system-values-item"><a href="javascript:void(0);" data-widgetmodal_url="https://demo-jp.exment.net/admin/data/user/1?modal=1" data-toggle="tooltip" title="データ確認"><span class="d-inline-block user-avatar-block">#{{ $jobitem->company->id }} {{ $jobitem->company->cname }}</span></a></p>
                            </li>
                            <li>
                                <p class="system-values-label">採用担当</p>
                                <p class="system-values-item"><a href="javascript:void(0);" data-widgetmodal_url="https://demo-jp.exment.net/admin/data/user/1?modal=1" data-toggle="tooltip" title="データ確認"><span class="d-inline-block user-avatar-block">#{{ $jobitem->employer->id }} {{ $jobitem->employer->full_name }}</span></a></p>
                            </li>
                            <li>
                                <p class="system-values-label">作成日時</p>
                                <p class="system-values-item">{{ $jobitem->created_at }}</p>
                            </li>
                            <li>
                                <p class="system-values-label">更新日時</p>
                                <p class="system-values-item">{{ $jobitem->updated_at }}</p>
                            </li>
                        </ul>
                    </div>
                    <hr>
                </div>
                <div class="body-box">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">ステータス</label>
                            <div class="col-sm-8">
                                {{ config('const.EMP_JOB_STATUS.' . $jobitem->status) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">キャッチコピー</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_title }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">職種</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_type }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">給与</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_salary }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">勤務先の企業名・店舗名</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_office }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">勤務先の住所</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_office_address }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">仕事内容</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_desc }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">紹介文</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_intro }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">昇給・賞与</label>
                            <div class="col-sm-8">
                                {{ $jobitem->salary_increase }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">勤務時間</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_time }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">応募資格</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_target }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">福利厚生</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_treatment }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">掲載開始日</label>
                            <div class="col-sm-8">
                                {{ $jobitem->start_date }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">掲載終了日</label>
                            <div class="col-sm-8">
                                {{ $jobitem->end_date }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">その他</label>
                            <div class="col-sm-8">
                                {{ $jobitem->remarks }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">質問１</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_q1 }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">質問２</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_q2 }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">質問３</label>
                            <div class="col-sm-8">
                                {{ $jobitem->job_q3 }}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">写真/画像</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    @foreach($imageArray as $image)
                                    <div class="col-sm-4 mb-3">
                                        <img src="{{ $image }}" class="w-100" alt="写真">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">動画</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    @foreach($movieArray as $movie)
                                    <div class="col-sm-4 mb-3">
                                        <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                            <source src="{{$movie}}" /></iframe>
                                        </video>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">雇用形態カテゴリ</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    {{ $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">職種カテゴリ</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    {{ $jobitem->categories()->wherePivot('ancestor_slug', 'type')->first()->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">勤務地カテゴリ</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    {{ $jobitem->categories()->wherePivot('ancestor_slug', 'area')->first()->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">最低給与カテゴリ</label>
                            <div class="col-sm-8">
                                @foreach($jobitem->categories()->wherePivot('ancestor_slug', 'salary')->get() as $category)
                                <div class="row">
                                    <p class="mb-1">{{ $category->parent->name }} : {{ $category->name }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-2 text-sm-right">最低勤務日数カテゴリ</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    {{ $jobitem->categories()->wherePivot('ancestor_slug', 'date')->first()->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
