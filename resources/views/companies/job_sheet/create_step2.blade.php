@extends('layouts.employer_mypage_master')

@section('title', '求人票| JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.employer.mypage_header')
@endcomponent
@endsection

@section('contents')
<div class="main-wrap">
    <section class="main-section job-create-section">
        <div class="inner">
            <div class="pad">
                <div class="job-progress only-pc">
                    <ul>
                        <li>
                            <p class="job-step">STEP１</p>
                            <p>カテゴリを選ぶ</p>
                        </li>
                        <li class="current-step">
                            <p class="job-step">STEP２</p>
                            <p>詳細を入力</p>
                        </li>
                        <li>
                            <p class="job-step">STEP３</p>
                            <p>求人票を登録</p>
                        </li>
                        <li>
                            <p>内容を確認し<br>承認作業をします</p>
                        </li>
                        <li>
                            <p>掲載開始</p>
                        </li>
                    </ul>
                </div>

                <div class="col-md-10 mr-auto ml-auto p-0">
                    @if(count($errors) > 0 || Session::has('message'))
                    <div class="alert alert-danger">
                        <strong><i class="fas fa-exclamation-circle"></i>エラー</strong><br>
                        <ul class="list-unstyled">
                            @if(Session::has('message'))
                            <li>{{ Session::get('message') }}</li>
                            @endif
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form name="JobSheetStep2" id="jobsheet-create-form" action="{{route('draftOrConfirm.jobsheet.step2', [$jobitem])}}" class="job-create jobSaveForm file-apload-form" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="data[JobSheet][id]" value="{{$jobitem->id}}" id="JobSheetId">
                        <input type="hidden" name="data[JobSheet][pushed]" value="" id="JobSheetPushed" />
                        <div class="card">
                            <div class="card-header">募集カテゴリ<span class="text-danger">＊</span></div>
                            <div class="card-body">
                                <table class="job-create-table jobcat-edit-create-table">
                                    <tr>
                                        <th>雇用形態</th>
                                        <td>
                                            <span id="JobSheetStep2CategoryStatusName">
                                                {{$jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name}}
                                            </span>

                                        </td>
                                        <td><a href="{{route('edit.jobsheet.category', [$jobitem->id, 'category'=>'status'])}}" class="txt-blue-link" target="_blank">変更する</a></td>
                                    </tr>
                                    <tr>
                                        <th>職種</th>
                                        <td>
                                            <span id="JobSheetStep2CategoryTypeName">
                                                {{$jobitem->categories()->wherePivot('ancestor_slug', 'type')->first()->name}}
                                            </span>
                                        </td>
                                        <td><a href="{{route('edit.jobsheet.category', [$jobitem->id, 'category'=>'type'])}}" class="txt-blue-link" target="_blank">変更する</a></td>
                                    </tr>
                                    <tr>
                                        <th>勤務地エリア</th>
                                        <td>
                                            <span id="JobSheetStep2CategoryAreaName">
                                                {{$jobitem->categories()->wherePivot('ancestor_slug', 'area')->first()->name}}
                                            </span>

                                        </td>
                                        <td><a href="{{route('edit.jobsheet.category', [$jobitem->id, 'category'=>'area'])}}" class="txt-blue-link" target="_blank">変更する</a></td>
                                    </tr>
                                    <tr>
                                        <th>最低給与</th>
                                        <td>
                                            <span id="JobSheetStep2CategorySalaryName">
                                                @foreach($jobitem->categories()->wherePivot('ancestor_slug', 'salary')->get() as $category)
                                                <p>{{$category->parent->name}}: {{$category->name}}</p>
                                                @endforeach
                                            </span>

                                        </td>
                                        <td><a href="{{route('edit.jobsheet.category', [$jobitem->id, 'category'=>'salary'])}}" class="txt-blue-link" target="_blank">変更する</a></td>
                                    </tr>
                                    <tr>
                                        <th>最低勤務日数</th>
                                        <td>
                                            <span id="JobSheetStep2CategoryDateName">
                                                {{$jobitem->categories()->wherePivot('ancestor_slug', 'date')->first()->name}}
                                            </span>

                                        </td>
                                        <td><a href="{{route('edit.jobsheet.category', [$jobitem->id, 'category'=>'date'])}}" class="txt-blue-link" target="_blank">変更する</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">写真/画像（メイン写真は必ず登録してください）<span class="text-danger">＊</span></div>
                            <div class="card-body">
                                <div class="form-group e-image-register-area">
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap">
                                            <img src="@if($jobitem->job_img_1) {{ $jobBaseUrl . config('fpath.job_sheet_img') . $jobitem->job_img_1 . '?' . date('YmdHis') }} @else {{asset('img/common/no-image.gif')}} @endif" alt="メイン写真を登録してください" name="photo1" id="photo1">
                                            <input type="hidden" name="data[File][isExist1]" value="@if($jobitem->job_img_1){{1}}@else{{0}}@endif" id="FileIsExist1" />
                                        </p>
                                        <p class="text-center">
                                            <a class="btn-gradient-3d-orange" href="{{route('edit.jobsheet.mainimage', $jobitem)}}" target="_blank">メイン写真を登録</a>
                                        </p>
                                    </div>
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap">
                                            <img src="@if($jobitem->job_img_2) {{ $jobBaseUrl . config('fpath.job_sheet_img') . $jobitem->job_img_2 . '?' . date('YmdHis') }} @else {{asset('img/common/no-image.gif')}} @endif" alt="サブ写真を登録してください" name="photo2" id="photo2">
                                            <input type="hidden" name="data[File][isExist2]" value="0" id="FileIsExist2" />
                                        </p>
                                        <p class="text-center">
                                            <a class="btn-gradient-3d-orange" href="{{route('edit.jobsheet.subimage1', $jobitem)}}" target="_blank">サブ写真を登録</a>
                                        </p>
                                    </div>
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap">
                                            <img src="@if($jobitem->job_img_3) {{ $jobBaseUrl . config('fpath.job_sheet_img') . $jobitem->job_img_3 . '?' . date('YmdHis') }} @else {{asset('img/common/no-image.gif')}} @endif" alt="サブ写真を登録してください" name="photo3" id="photo3">
                                            <input type="hidden" name="data[File][isExist3]" value="0" id="FileIsExist3" />
                                        </p>
                                        <p class="text-center">
                                            <a class="btn-gradient-3d-orange" href="{{route('edit.jobsheet.subimage2', $jobitem)}}" target="_blank">サブ写真を登録</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">動画 (職場の雰囲気や魅力を届けましょう）</div>
                            <div class="card-body">
                                <div oncontextmenu="return false;" class="form-group e-image-register-area">
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap">
                                            <video src="@if($jobitem->job_mov_1) {{ $jobBaseUrl . config('fpath.job_sheet_mov') . $jobitem->job_mov_1 . '?' . date('YmdHis') }} @endif" controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%" name="film1" id="film1">
                                            </video>
                                        </p>
                                        <p class="text-center">
                                            <a class="btn-gradient-3d-blue" href="{{route('edit.jobsheet.mainmovie', $jobitem)}}" target="_blank">メイン動画を登録</a>
                                        </p>
                                    </div>
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap">
                                            <video src="@if($jobitem->job_mov_2) {{ $jobBaseUrl . config('fpath.job_sheet_mov') . $jobitem->job_mov_2 . '?' . date('YmdHis') }}@endif" controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%" name="film2" id="film2">
                                            </video>
                                        </p>
                                        <p class="text-center">
                                            <a class="btn-gradient-3d-blue" href="{{route('edit.jobsheet.submovie1', $jobitem)}}" target="_blank">サブ動画を登録</a>
                                        </p>
                                    </div>
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap">
                                            <video src="@if($jobitem->job_mov_3) {{ $jobBaseUrl . config('fpath.job_sheet_mov') . $jobitem->job_mov_3 . '?' . date('YmdHis') }}@endif" controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%" name="film3" id="film3">
                                            </video>
                                        </p>
                                        <p class="text-center">
                                            <a class="btn-gradient-3d-blue" href="{{route('edit.jobsheet.submovie2', $jobitem)}}" target="_blank">サブ動画を登録</a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div> <!-- card -->
                        @if($editFlag === 1)
                        <div class="card">
                            <div class="card-header">掲載期間<span class="text-danger">＊</span></div>
                            <div class="card-body">
                                <table class="job-create-table">
                                    <tr>
                                        <th>掲載開始日</th>
                                        <td>
                                            <input id="shortest" type="radio" name="data[JobSheet][pub_start_flag]" value="0" checked @if(old('data.JobSheet.pub_start_flag')==="0" ){{'checked'}}@elseif(Session::get('data.JobSheet.pub_start_flag')===0){{'checked'}}@endif>
                                            <label for="shortest">最短で掲載</label><br>
                                            <input id="start_specified" type="radio" name="data[JobSheet][pub_start_flag]" value="1" @if(old('data.JobSheet.pub_start_flag')==="1" ){{'checked'}}@elseif(Session::get('data.JobSheet.pub_start_flag')===1){{'checked'}}@endif>
                                            <label for="start_specified">掲載開始日を指定</label><input class="ml-2" id="start_specified_date" disabled="disabled" type="date" name="data[JobSheet][pub_start_date]" value="@if(old('data.JobSheet.pub_start_date')){{old('data.JobSheet.pub_start_date')}}@elseif(Session::has('data.JobSheet.pub_start_date')){{Session::get('data.JobSheet.pub_start_date')}}@endif" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>掲載終了日</th>
                                        <td>
                                            <input id="not_specified" type="radio" name="data[JobSheet][pub_end_flag]" value="0" checked @if(old('data.JobSheet.pub_end_flag')==="0" ){{ 'checked' }}@elseif(Session::get('data.JobSheet.pub_end_flag')===0){{'checked'}} @endif>
                                            <label for="not_specified">無期限で掲載</label><br>
                                            <input id="end_specified" type="radio" name="data[JobSheet][pub_end_flag]" value="1" @if(old('data.JobSheet.pub_end_flag')==="1" ){{ 'checked' }}@elseif(Session::get('data.JobSheet.pub_end_flag')===1){{ 'checked' }} @endif>
                                            <label for="end_specified">掲載終了日を指定</label><input class="ml-2" id="end_specified_date" type="date" name="data[JobSheet][pub_end_date]" disabled="disabled" value="@if(old('data.JobSheet.pub_end_date')){{old('data.JobSheet.pub_end_date')}}@elseif(Session::has('data.JobSheet.pub_end_date')){{Session::get('data.JobSheet.pub_end_date')}}@endif" required><br>
                                        </td>
                                    </tr>
                                </table>
                                <p class="text-danger mt-2">※求人票の内容を審査いたしますので、日数がかかる場合がございます。</p>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">募集内容<span class="text-danger">＊</span></div>
                            <div class="card-body">
                                <table class="job-create-table">
                                    <tr>
                                        <th>キャッチコピー<span class="text-danger">（必須）</span>
                                            <span id="inputlength1">（0/30字）</span>
                                        </th>
                                        <td>
                                            <input type="text" id="SheetHeadline" onkeyup="ShowLength('inputlength1', value, 30)" name="data[JobSheet][job_title]" class="form-control {{ $errors->has('data.JobSheet.job_title') ? 'is-invalid' : ''}}" value="@if(old('data.JobSheet.job_title')){{ old('data.JobSheet.job_title') }}@else{{Session::get('data.JobSheet.job_title')}}@endif">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>紹介文<span class="text-danger">（必須）</span>
                                            <span id="inputlength2">（0/250字）</span>
                                        </th>
                                        <td>
                                            <textarea onkeyup="ShowLength('inputlength2', value, 250);" name="data[JobSheet][job_intro]" id="JobSheetMessage" class="form-control {{ $errors->has('data.JobSheet.job_intro') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_intro')){{ old('data.JobSheet.job_intro') }}@else{{Session::get('data.JobSheet.job_intro')}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>勤務先<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <p class="text-danger mb-2">勤務する会社名（支店名）・店舗名などご入力ください</p>
                                            <textarea type="text" name="data[JobSheet][job_office]" class="form-control {{ $errors->has('data.JobSheet.job_office') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_office')){{old('data.JobSheet.job_office')}}@elseif(Session::has('data.JobSheet.job_office')){{Session::get('data.JobSheet.job_office')}}@elseif(!old('data.JobSheet.job_office')){{auth('employer')->user()->company->cname}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>住所<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <p class="text-danger mb-2">勤務地が複数ある場合には複数ご入力ください</p>
                                            <textarea type="text" name="data[JobSheet][job_office_address]" class="form-control {{ $errors->has('data.JobSheet.job_office_address') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_office_address')){{ old('data.JobSheet.job_office_address') }}@else{{Session::get('data.JobSheet.job_office_address')}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>職種<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <input type="text" name="data[JobSheet][job_type]" class="form-control {{ $errors->has('data.JobSheet.job_type') ? 'is-invalid' : ''}}" value="@if(old('data.JobSheet.job_type')){{ old('data.JobSheet.job_type') }}@else{{Session::get('data.JobSheet.job_type')}}@endif">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>仕事内容<span class="text-danger">（必須）</span>
                                            <span id="inputlength3">（0/700字）</span>
                                        </th>
                                        <td>
                                            <p class="text-danger mb-2">具体的な仕事の内容、業務の範囲などをご入力ください</p>
                                            <textarea type="text" name="data[JobSheet][job_desc]" onkeyup="ShowLength('inputlength3', value, 700)" id="JobSheetBusiness" class="form-control {{ $errors->has('data.JobSheet.job_desc') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_desc')){{ old('data.JobSheet.job_desc') }}@else{{Session::get('data.JobSheet.job_desc')}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>給与<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <textarea type="text" name="data[JobSheet][job_salary]" class="form-control {{ $errors->has('data.JobSheet.job_salary') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_salary')){{ old('data.JobSheet.job_salary') }}@else{{Session::get('data.JobSheet.job_salary')}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>昇給・賞与</th>
                                        <td>
                                            <textarea type="text" name="data[JobSheet][salary_increase]" class="form-control {{ $errors->has('data.JobSheet.salary_increase') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.salary_increase')){{ old('data.JobSheet.salary_increase') }}@else{{Session::get('data.JobSheet.salary_increase')}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>応募資格<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <textarea type="text" name="data[JobSheet][job_target]" class="form-control {{ $errors->has('data.JobSheet.job_target') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_target')){{ old('data.JobSheet.job_target') }}@else{{Session::get('data.JobSheet.job_target')}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>勤務時間<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <textarea type="text" name="data[JobSheet][job_time]" class="form-control {{ $errors->has('data.JobSheet.job_time') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_time')){{ old('data.JobSheet.job_time') }}@else{{Session::get('data.JobSheet.job_time')}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>待遇・福利厚生<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <p class="text-danger mb-2">各種保険や交通費支給などご入力ください</p>
                                            <textarea type="text" name="data[JobSheet][job_treatment]" class="form-control {{ $errors->has('data.JobSheet.job_treatment') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_treatment')){{ old('data.JobSheet.job_treatment') }}@else{{Session::get('data.JobSheet.job_treatment')}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>その他
                                            <span id="inputlength4">（0/1300字）</span>
                                        </th>
                                        <td>
                                            <p class="text-danger mb-2">その他に定める事や応募者への連絡事項など、ご自由にご入力ください</p>
                                            <textarea type="text" name="data[JobSheet][remarks]" onkeyup="ShowLength('inputlengthEtc', value, 1300);" id="JobSheetEtc" class="form-control {{ $errors->has('data.JobSheet.remarks') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.remarks')){{ old('data.JobSheet.remarks') }}@else{{Session::get('data.JobSheet.remarks')}}@endif</textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">企業から求職者への質問</div>
                            <div class="card-body">
                                <table class="job-create-table">
                                    <tr>
                                        <th>質問１</th>
                                        <td>
                                            <input type="text" name="data[JobSheet][job_q1]" class="form-control {{ $errors->has('data.JobSheet.job_q1') ? 'is-invalid' : ''}}" value="@if(old('data.JobSheet.job_q1')){{ old('data.JobSheet.job_q1') }}@else{{Session::get('data.JobSheet.job_q1')}}@endif">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>質問2</th>
                                        <td>
                                            <input type="text" name="data[JobSheet][job_q2]" class="form-control {{ $errors->has('data.JobSheet.job_q2') ? 'is-invalid' : ''}}" value="@if(old('data.JobSheet.job_q2')){{ old('data.JobSheet.job_q2') }}@else{{Session::get('data.JobSheet.job_q2')}}@endif">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>質問3</th>
                                        <td>
                                            <input type="text" name="data[JobSheet][job_q3]" class="form-control {{ $errors->has('data.JobSheet.job_q3') ? 'is-invalid' : ''}}" value="@if(old('data.JobSheet.job_q3')){{ old('data.JobSheet.job_q3') }}@else{{Session::get('data.JobSheet.job_q3')}}@endif">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div> <!-- card -->
                        @else
                        <div class="card">
                            <div class="card-header">掲載期間<span class="text-danger">＊</span></div>
                            <div class="card-body">
                                <table class="job-create-table">
                                    <tr>
                                        <th>掲載開始日</th>
                                        <td>
                                            <input id="shortest" type="radio" name="data[JobSheet][pub_start_flag]" value="0" checked @if(old('data.JobSheet.pub_start_flag')==="0" ){{'checked'}}@elseif($jobitem->pub_start_flag === 0){{'checked'}}@endif>
                                            <label for="shortest">最短で掲載</label><br>
                                            <input id="start_specified" type="radio" name="data[JobSheet][pub_start_flag]" value="1" @if(old('data.JobSheet.pub_start_flag')==="1" ){{ 'checked'}} @elseif($jobitem->pub_start_flag === 1){{'checked'}}@endif>
                                            <label for="start_specified">掲載開始日を指定</label><input class="ml-2" id="start_specified_date" type="date" name="data[JobSheet][pub_start_date]" value="@if(old('data.JobSheet.pub_start_date')){{old('data.JobSheet.pub_start_date')}}@elseif($jobitem->pub_start_date){{$jobitem->pub_start_date->format('yy-m-d')}}@endif" required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>掲載終了日</th>
                                        <td>
                                            <input id="not_specified" type="radio" name="data[JobSheet][pub_end_flag]" value="0" checked @if(old('data.JobSheet.datazpub_end_flag')==="0" ){{'checked'}}@elseif($jobitem->pub_end_flag === 0){{'checked'}}@endif>
                                            <label for="not_specified">無期限で掲載</label><br>
                                            <input id="end_specified" type="radio" name="data[JobSheet][pub_end_flag]" value="1" @if(old('data.JobSheet.pub_end_flag')==="1" ){{'checked'}}@elseif($jobitem->pub_end_flag === 1){{'checked'}}@endif>
                                            <label for="end_specified">掲載終了日を指定</label><input class="ml-2" id="end_specified_date" type="date" name="data[JobSheet][pub_end_date]" disabled="disabled" value="@if(old('data.JobSheet.pub_end_date')){{old('data.JobSheet.pub_end_date')}}@elseif($jobitem->pub_end_date){{$jobitem->pub_end_date->format('yy-m-d')}}@endif" required><br>
                                        </td>
                                    </tr>
                                </table>
                                <p class="text-danger mt-2">※求人票の内容を審査いたしますので、日数がかかる場合がございます。</p>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">募集内容<span class="text-danger">＊</span></div>
                            <div class="card-body">
                                <table class="job-create-table">
                                    <tr>
                                        <th>キャッチコピー<span class="text-danger">（必須）</span>
                                            <span id="inputlength1">（0/30字）</span>
                                        </th>
                                        <td>
                                            <input type="text" id="SheetHeadline" onkeyup="ShowLength('inputlength1', value, 30)" name="data[JobSheet][job_title]" class="form-control {{ $errors->has('data.JobSheet.job_title') ? 'is-invalid' : ''}}" value="@if(old('data.JobSheet.job_title')){{ old('data.JobSheet.job_title') }}@else{{$jobitem->job_title}}@endif">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>紹介文<span class="text-danger">（必須）</span>
                                            <span id="inputlength2">（0/250字）</span>
                                        </th>
                                        <td>
                                            <textarea onkeyup="ShowLength('inputlength2', value, 250);" name="data[JobSheet][job_intro]" id="JobSheetMessage" class="form-control {{ $errors->has('data.JobSheet.job_intro') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_intro')){{ old('data.JobSheet.job_intro') }}@else{{$jobitem->job_intro}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>勤務先<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <p class="text-danger mb-2">勤務する会社名（支店名）・店舗名などご入力ください</p>
                                            <textarea type="text" name="data[JobSheet][job_office]" class="form-control {{ $errors->has('data.JobSheet.job_office') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_office')){{old('data.JobSheet.job_office')}}@elseif($jobitem->job_office){{$jobitem->job_office}}@elseif(!old('data.JobSheet.job_office')){{auth('employer')->user()->company->cname}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>住所<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <p class="text-danger mb-2">勤務地が複数ある場合には複数ご入力ください</p>
                                            <textarea type="text" name="data[JobSheet][job_office_address]" class="form-control {{ $errors->has('data.JobSheet.job_office_address') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_office_address')){{ old('data.JobSheet.job_office_address') }}@else{{$jobitem->job_office_address}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>職種<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <input type="text" name="data[JobSheet][job_type]" class="form-control {{ $errors->has('data.JobSheet.job_type') ? 'is-invalid' : ''}}" value="@if(old('data.JobSheet.job_type')){{ old('data.JobSheet.job_type') }}@else{{$jobitem->job_type}}@endif">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>仕事内容<span class="text-danger">（必須）</span>
                                            <span id="inputlength3">（0/700字）</span>
                                        </th>
                                        <td>
                                            <p class="text-danger mb-2">具体的な仕事の内容、業務の範囲などをご入力ください</p>
                                            <textarea type="text" name="data[JobSheet][job_desc]" onkeyup="ShowLength('inputlength3', value, 700)" id="JobSheetBusiness" class="form-control {{ $errors->has('data.JobSheet.job_desc') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_desc')){{ old('data.JobSheet.job_desc') }}@else{{$jobitem->job_desc}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>給与<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <textarea type="text" name="data[JobSheet][job_salary]" class="form-control {{ $errors->has('data.JobSheet.job_salary') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_salary')){{ old('data.JobSheet.job_salary') }}@else{{$jobitem->job_salary}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>昇給・賞与</th>
                                        <td>
                                            <textarea type="text" name="data[JobSheet][salary_increase]" class="form-control {{ $errors->has('data.JobSheet.salary_increase') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.salary_increase')){{ old('data.JobSheet.salary_increase') }}@else{{$jobitem->salary_increase}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>応募資格<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <textarea type="text" name="data[JobSheet][job_target]" class="form-control {{ $errors->has('data.JobSheet.job_target') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_target')){{ old('data.JobSheet.job_target') }}@else{{$jobitem->job_target}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>勤務時間<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <textarea type="text" name="data[JobSheet][job_time]" class="form-control {{ $errors->has('data.JobSheet.job_time') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_time')){{ old('data.JobSheet.job_time') }}@else{{$jobitem->job_time}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>待遇・福利厚生<span class="text-danger">（必須）</span></th>
                                        <td>
                                            <p class="text-danger mb-2">各種保険や交通費支給などご入力ください</p>
                                            <textarea type="text" name="data[JobSheet][job_treatment]" class="form-control {{ $errors->has('data.JobSheet.job_treatment') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.job_treatment')){{ old('data.JobSheet.job_treatment') }}@else{{$jobitem->job_treatment}}@endif</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>その他
                                            <span id="inputlength4">（0/1300字）</span>
                                        </th>
                                        <td>
                                            <p class="text-danger mb-2">その他に定める事や応募者への連絡事項など、ご自由にご入力ください</p>
                                            <textarea type="text" name="data[JobSheet][remarks]" onkeyup="ShowLength('inputlengthEtc', value, 1300);" id="JobSheetEtc" class="form-control {{ $errors->has('data.JobSheet.remarks') ? 'is-invalid' : ''}}">@if(old('data.JobSheet.remarks')){{ old('data.JobSheet.remarks') }}@else{{$jobitem->remarks}}@endif</textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">企業から求職者への質問</div>
                            <div class="card-body">
                                <table class="job-create-table">
                                    <tr>
                                        <th>質問１</th>
                                        <td>
                                            <input type="text" name="data[JobSheet][job_q1]" class="form-control {{ $errors->has('data.JobSheet.job_q1') ? 'is-invalid' : ''}}" value="@if(old('data.JobSheet.job_q1')){{ old('data.JobSheet.job_q1') }}@else{{$jobitem->job_q1}}@endif">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>質問2</th>
                                        <td>
                                            <input type="text" name="data[JobSheet][job_q2]" class="form-control {{ $errors->has('data.JobSheet.job_q2') ? 'is-invalid' : ''}}" value="@if(old('data.JobSheet.job_q2')){{ old('data.JobSheet.job_q2') }}@else{{$jobitem->job_q2}}@endif">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>質問3</th>
                                        <td>
                                            <input type="text" name="data[JobSheet][job_q3]" class="form-control {{ $errors->has('data.JobSheet.job_q3') ? 'is-invalid' : ''}}" value="@if(old('data.JobSheet.job_q3')){{ old('data.JobSheet.job_q3') }}@else{{$jobitem->job_q3}}@endif">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div> <!-- card -->
                        @endif
                        <div class="form-group text-center">
                            <button type="button" id="SaveJob" class="btn btn-dark" name="storestep2">確認画面へ進む</button>
                            @if($jobitem->status !== 2)
                            <button type="button" id="SaveTmpJob" class="btn btn-outline-secondary">一時保存する</button>
                            @endif
                        </div>
                        <div class="form-group text-center">
                            <a class="btn back-btn ml-3" href="javascript:void(0);" onClick="window.opener.location.reload(),window.close()"><i class="fas fa-reply mr-3"></i>閉じる</a>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- inner -->
    </section>
</div> <!-- main-wrap -->
@endsection

@section('footer')
@component('components.employer.mypage_footer')
@endcomponent
@endsection


@section('js')
<script>
    function ShowLength(idn, str, lmtlen) {
        var mdfy_s = '<span class = "d-block">';
        if (str.length > lmtlen) {
            var mdfy_s = '<span class = "text-danger d-block">';
        }
        document.getElementById(idn).innerHTML = mdfy_s + "（" + str.length + "/" + lmtlen + "字）</span>";
    }

    function submit(event, type) {
        event.preventDefault();
        $('#JobSheetPushed').attr('value', type);
        document.JobSheetStep2.submit();
    }

    $(function() {
        var str1 = $('#SheetHeadline').val();
        ShowLength('inputlength1', str1, 30);

        var str2 = $('#JobSheetMessage').val();
        ShowLength('inputlength2', str2, 250);

        var str3 = $('#JobSheetBusiness').val();
        ShowLength('inputlength3', str3, 700);

        var str4 = $('#JobSheetEtc').val();
        ShowLength('inputlength4', str4, 1300);

        $("#SaveJob").click(function(event) {
            submit(event, 'SaveJob');
        });
        $("#SaveTmpJob").click(function(event) {
            submit(event, 'SaveTmpJob');
        });

        $("#start_specified_date, #end_specified_date").datepicker({
            dateFormat: 'yy-mm-dd',
        });
    });
</script>


@endsection
