@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 求人票テーブル')

@section('content_header')
<h1><i class="fas fa-edit mr-2"></i>求人票テーブル</h1>
@stop

@section('content_bread')
<li class="breadcrumb-item"><a href="{{ route('job_sheet.index') }}">求人票テーブル</a></li>
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
                        <a href="{{ route('job_sheet.show', $jobitem->id) }}" class="btn btn-sm btn-primary" title="編集">
                            <i class="fa fa-edit"></i><span class="hidden-xs"> 表示</span>
                        </a>
                    </div>
                    <div class="btn-group" style="margin-right: 5px">
                        <a href="{{ route('job_sheet.index') }}" class="btn btn-sm btn-default" title="一覧">
                            <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
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
                <form action="{{ route('job_sheet.update', $jobitem->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                            <div class="row align-items-center">
                                <label class="col-sm-2 text-sm-right">ステータス</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <select class="custom-select" name="data[JobSheet][status]" required="1">
                                            @foreach(config('const.EMP_JOB_STATUS') as $key => $value)
                                            <option value="{{ $key }}" @if(old('data.JobSheet.status')===(string) $key){{ 'selected' }}@else{{ $key === $jobitem->status ? 'selected' : ''}}@endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">キャッチコピー</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][job_title]" class="form-control" placeholder="入力 キャッチコピー">{{ old('data.JobSheet.job_title') ?: $jobitem->job_title }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">紹介文</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][job_intro]" class="form-control" placeholder="入力 紹介文">{{ old('data.JobSheet.job_intro') ?: $jobitem->job_intro }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label class="col-sm-2 text-sm-right">職種</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input name="data[JobSheet][job_type]" value="{{ old('data.JobSheet.job_type') ?: $jobitem->job_type }}" class="form-control" placeholder="入力 職種">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">給与</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][job_salary]" class="form-control" placeholder="入力 給与">{{ old('data.JobSheet.job_salary') ?: $jobitem->job_salary }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">勤務先の企業名・店舗名</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][job_office]" class="form-control" placeholder="入力 勤務先の企業名・店舗名">{{ old('data.JobSheet.job_office') ?: $jobitem->job_office }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">勤務先の住所</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][job_office_address]" class="form-control" placeholder="入力 勤務先の住所">{{ old('data.JobSheet.job_office_address') ?: $jobitem->job_office_address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">仕事内容</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][job_desc]" class="form-control" placeholder="入力 仕事内容">{{ old('data.JobSheet.job_desc') ?: $jobitem->job_desc }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">昇給・賞与</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][salary_increase]" class="form-control" placeholder="入力 昇給・賞与">{{ old('data.JobSheet.salary_increase') ?: $jobitem->salary_increase }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">勤務時間</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][job_time]" class="form-control" placeholder="入力 勤務時間">{{ old('data.JobSheet.job_time') ?: $jobitem->job_time }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">応募資格</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][job_target]" class="form-control" placeholder="入力 応募資格">{{ old('data.JobSheet.job_target') ?: $jobitem->job_target }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">福利厚生</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][job_treatment]" class="form-control" placeholder="入力 福利厚生">{{ old('data.JobSheet.job_treatment') ?: $jobitem->job_treatment }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">掲載開始日</label>
                                <div class="col-sm-8">
                                    <div class="form-group mb-1">
                                        <input type="radio" name="data[JobSheet][pub_start_flag]" @if(old('data.JobSheet.pub_start_flag')=='0' ){{ 'checked' }}@else{{ $jobitem->pub_start_flag === 0 ? 'checked' : ''}}@endif value="0" id="shortest">
                                        <label for="shortest">最短で掲載</label>
                                    </div>
                                    <div class="input-group align-items-center">
                                        <div class="form-group mb-0">
                                            <input type="radio" name="data[JobSheet][pub_start_flag]" @if(old('data.JobSheet.pub_start_flag')=='1' ){{ 'checked' }}@else{{ $jobitem->pub_start_flag === 1 ? 'checked' : ''}}@endif value="1" id="start_specified">
                                            <label for="start_specified">掲載開始日を指定</label>
                                        </div>
                                        <input type="text" id="start_specified_date" name="data[JobSheet][pub_start_date]" class="form-control ml-3" value="@if(old('data.JobSheet.pub_start_date')){{ old('data.JobSheet.pub_start_date') }}@else{{ $jobitem->pub_start_date ? $jobitem->pub_start_date->format('Y-m-d') : '' }}@endif">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-5">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">掲載終了日</label>
                                <div class="col-sm-8">
                                    <div class="form-group mb-1">
                                        <input type="radio" name="data[JobSheet][pub_end_flag]" @if(old('data.JobSheet.pub_end_flag')=='0' ){{ 'checked' }}@else{{ $jobitem->pub_end_flag === 0 ? 'checked' : ''}}@endif value="0" id="not_specified">
                                        <label for="not_specified">無期限で掲載</label>
                                    </div>
                                    <div class="input-group align-items-center">
                                        <div class="form-group mb-0">
                                            <input type="radio" name="data[JobSheet][pub_end_flag]" @if(old('data.JobSheet.pub_end_flag')=='1' ){{ 'checked' }}@else{{ $jobitem->pub_end_flag === 1 ? 'checked' : ''}}@endif value="1" id="end_specified">
                                            <label for="end_specified">掲載終了日を指定</label>
                                        </div>
                                        <input type="text" id="end_specified_date" name="data[JobSheet][pub_end_date]" class="form-control ml-3" value="@if(old('data.JobSheet.pub_end_date')){{ old('data.JobSheet.pub_end_date') }}@else{{ $jobitem->pub_end_date ? $jobitem->pub_end_date->format('Y-m-d') : '' }}@endif">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">その他</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <textarea name="data[JobSheet][remarks]" class="form-control" placeholder="入力 その他">{{ old('data.JobSheet.remarks') ?: $jobitem->remarks }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">質問１</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input name="data[JobSheet][job_q1]" class="form-control" value="{{ old('data.JobSheet.job_q1') ?: $jobitem->job_q1 }}" placeholder="入力 質問１">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">質問２</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input name="data[JobSheet][job_q2]" class="form-control" value="{{ old('data.JobSheet.job_q2') ?: $jobitem->job_q2 }}" placeholder="入力 質問２">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">質問３</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input name="data[JobSheet][job_q3]" class="form-control" value="{{ old('data.JobSheet.job_q3') ?: $jobitem->job_q3 }}" placeholder="入力 質問３">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">写真/画像</label>
                                <div class="col-sm-8">
                                    @foreach($imageArray as $index => $image)
                                    <div class="col-12 py-2 border mb-3">
                                        <p class="mr-3">写真{{ $index + 1 }} (<span class="font-red">{{ $jobitem->{'job_img_'. ($index + 1)} ? '登録中' : '未登録'}}</span>)</p>
                                        <input name="data[File][image][{{ $index }}][image]" type="file" id="FileImage{{ $index }}" accept=".jpg,.gif,.png,image/gif,image/jpeg,image/png">
                                        <p class="mt-3"><input type="checkbox" id="ImageDeleteFlag{{ $index }}" name="data[File][image][{{ $index }}][delete]" value="1" {{ old('data.File.image.' . $index . '.delete') ? 'checked': '' }}><label for="ImageDeleteFlag{{ $index }}">削除する</label></p>
                                        <div class="mt-2">
                                            <img src="{{ $image }}" class="w-100" alt="写真">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-2 text-sm-right">動画</label>
                                <div class="col-sm-8">
                                    @foreach($movieArray as $index => $movie)
                                    <div class="col-12 py-2 border mb-3">
                                        <p class="mr-3 font-bold">動画{{ $index + 1 }} (<span class="font-red">{{ $jobitem->{'job_mov_'. ($index + 1)} ? '登録中' : '未登録'}}</span>)</p>
                                        <input name="data[File][movie][{{ $index }}][movie]" type="file" id="FileMovie{{ $index }}" accept="video/*">
                                        <p class="mt-3"><input type="checkbox" id="MovieDeleteFlag{{ $index }}" name="data[File][movie][{{ $index }}][delete]" value="1" {{ old('data.File.movie.' . $index . '.delete') ? 'checked': '' }}><label for="MovieDeleteFlag{{ $index }}">削除する</label></p>
                                        <div class="mt-2">
                                            <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                                <source src="{{ $movie }}" /></iframe>
                                            </video>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">雇用形態カテゴリ</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <select class="custom-select" name="data[JobSheet][categories][status][id]">
                                                @foreach($categoryList->where('slug', 'status')->first()->children as $pIndex => $statusCategory)
                                                <option @if(intval(old('data.JobSheet.categories.status.id'))==$statusCategory->id){{ 'selected' }}@else{{ $statusCategory->id === $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->id ? 'selected' : '' }}@endif value="{{ $statusCategory->id }}">{{ $statusCategory->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="data[JobSheet][categories][status][ancestor_slug]" value="{{$categoryList[0]->slug}}">
                                            <input type="hidden" name="data[JobSheet][categories][status][ancestor_id]" value="{{$categoryList[0]->id}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">職種カテゴリ</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <select class="custom-select" name="data[JobSheet][categories][type][id]">
                                                <option value="">選択してください</option>
                                                @foreach($categoryList->where('slug', 'type')->first()->children as $pIndex => $typeCategory)
                                                <option @if(intval(old('data.JobSheet.categories.type.id'))==$typeCategory->id){{ 'selected' }}@else{{ $typeCategory->id === $jobitem->categories()->wherePivot('ancestor_slug', 'type')->first()->id ? 'selected' : '' }}@endif value="{{ $typeCategory->id }}">{{ $typeCategory->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="data[JobSheet][categories][type][ancestor_slug]" value="{{$categoryList[1]->slug}}">
                                            <input type="hidden" name="data[JobSheet][categories][type][ancestor_id]" value="{{$categoryList[1]->id}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">勤務地カテゴリ</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <select class="custom-select" name="data[JobSheet][categories][area][id]">
                                                <option value="">選択してください</option>
                                                @foreach($categoryList->where('slug', 'area')->first()->children as $pIndex => $areaCategory)
                                                <option @if(intval(old('data.JobSheet.categories.area.id'))==$areaCategory->id){{ 'selected' }}@else{{ $areaCategory->id === $jobitem->categories()->wherePivot('ancestor_slug', 'area')->first()->id ? 'selected' : '' }}@endif value="{{ $areaCategory->id }}">{{ $areaCategory->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="data[JobSheet][categories][area][ancestor_slug]" value="{{$categoryList[2]->slug}}">
                                            <input type="hidden" name="data[JobSheet][categories][area][ancestor_id]" value="{{$categoryList[2]->id}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">最低給与カテゴリ</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $pSalaries = $jobitem->categories()->wherePivot('ancestor_slug', 'salary')->get();
                                        ?>
                                        @foreach($categoryList->where('slug', 'salary')->first()->children as $pIndex => $salaryCategory)
                                        <div class="row mb-2 align-items-center">
                                            <?php
                                            $filtered = collect();
                                            $filteredId = '';
                                            if (!$pSalaries->isEmpty()) {
                                                $filtered = $pSalaries->filter(function ($value) use ($salaryCategory) {
                                                    return $value->parent->id === $salaryCategory->id && $value->slug != 'unregistered';
                                                });
                                            }
                                            if (!$filtered->isEmpty()) {
                                                $filteredId = $filtered->first()->id;
                                            }

                                            ?>
                                            <div class="col-3">
                                                <input id="salary_cats_{{$pIndex}}" class="jc-jsc-salary-money-selectfield" type="checkbox" name="data[JobSheet][categories][salary][{{$pIndex}}][parent_id]" @if(intval(old('data.JobSheet.categories.salary.' . $pIndex . '.parent_id' ))===$salaryCategory->id){{ 'checked' }}@else{{ !$filtered->isEmpty() ? 'checked' : '' }}@endif value={{ $salaryCategory->id }}>
                                                <label for="salary_cats_{{$pIndex}}">{{ $salaryCategory->name }}</label>
                                                <input type="hidden" name="data[JobSheet][categories][salary][{{$pIndex}}][parent_slug]" value="{{$salaryCategory->slug}}">
                                            </div>
                                            <select name="data[JobSheet][categories][salary][{{$pIndex}}][id]" id="e_radio_cat_item_c_salary_{{$pIndex}}" class="col-6 custom-select">
                                                @foreach($salaryCategory->children as $cIndex => $cat)
                                                <option value="{{$cat->id}}" @if(intval(old('data.JobSheet.categories.salary.' . $pIndex . '.id' ))===$cat->id){{ 'selected' }}@else{{ $filteredId===$cat->id ? 'selected' : ''}}@endif>{{$cat->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endforeach
                                        <input type="hidden" name="data[JobSheet][categories][salary_ancestor][slug]" value="{{$categoryList[3]->slug}}">
                                        <input type="hidden" name="data[JobSheet][categories][salary_ancestor][id]" value="{{$categoryList[3]->id}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">最低勤務日数カテゴリ</label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <select class="custom-select" name="data[JobSheet][categories][date][id]" id="">
                                                <option value="">選択してください</option>
                                                @foreach($categoryList->where('slug', 'date')->first()->children as $pIndex => $dateCategory)
                                                <option @if(intval(old('data.JobSheet.categories.date.id'))==$dateCategory->id){{ 'selected' }}@else{{ $dateCategory->id === $jobitem->categories()->wherePivot('ancestor_slug', 'date')->first()->id ? 'selected' : '' }}@endif value="{{ $dateCategory->id }}">{{ $dateCategory->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="data[JobSheet][categories][date][ancestor_slug]" value="{{$categoryList[4]->slug}}">
                                            <input type="hidden" name="data[JobSheet][categories][date][ancestor_id]" value="{{$categoryList[4]->id}}">
                                        </div>
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
        $('#start_specified_date').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja'
        }).on("changeDate", function(e) {
            $('#end_specified_date').datepicker('setStartDate', e.date);
        });
        $('#end_specified_date').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ja'
        }).on("changeDate", function(e) {
            $('#start_specified_date').datepicker('setEndDate', e.date);
        });

    });
</script>
@stop
