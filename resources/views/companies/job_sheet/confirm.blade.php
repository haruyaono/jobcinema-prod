@extends('layouts.employer_mypage_master')

@section('title', '求人票 | JOB CiNEMA')
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


                <div class="col-md-10 mr-auto ml-auto">
                    @if($jobitem->status !== 2)
                    <div class="border border-danger p-3 mb-4">
                        <p class="text-danger h3 mb-3">求人票の登録はまだ完了しておりません！</p>
                        下記の内容でお間違いなければ、登録ボタンを押してください。
                    </div>
                    @endif
                    <form action="{{ route('update.jobsheet.step2', [$jobitem]) }}" class="job-create file-apload-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">募集カテゴリ</div>
                            <div class="card-body">
                                <table class="job-create-table">
                                    <tr>
                                        <th>雇用形態</th>
                                        <td>
                                            <p>
                                                @foreach($jobitem->categories as $category)
                                                @if($category->parent->slug == 'status')
                                                {{App\Job\Categories\Category::find($category->id)->name}}
                                                @endif
                                                @endforeach
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>募集職種</th>
                                        <td>
                                            <p>
                                                @foreach($jobitem->categories as $category)
                                                @if($category->parent->slug == 'type')
                                                {{App\Job\Categories\Category::find($category->id)->name}}
                                                @endif
                                                @endforeach
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>勤務地エリア</th>
                                        <td>
                                            <p>
                                                @foreach($jobitem->categories as $category)
                                                @if($category->parent->slug == 'area')
                                                {{App\Job\Categories\Category::find($category->id)->name}}
                                                @endif
                                                @endforeach
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>最低給与</th>
                                        <td>
                                            <p>
                                                @foreach($jobitem->categories as $category)
                                                @if($category->parent->parent !== null && $category->parent->parent->slug == 'salary')
                                                <p>{{App\Job\Categories\Category::find($category->id)->parent->name}}: {{App\Job\Categories\Category::find($category->id)->name}}</p>
                                                @endif
                                                @endforeach
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>最低勤務日数</th>
                                        <td>
                                            <p>
                                                @foreach($jobitem->categories as $category)
                                                @if($category->parent->slug == 'date')
                                                {{App\Job\Categories\Category::find($category->id)->name}}
                                                @endif
                                                @endforeach
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">写真/画像</div>
                            <div class="card-body">
                                <div class="form-group e-image-register-area">
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap"><img src="@if($jobitem->job_img_1){{$jobBaseUrl . config('fpath.job_sheet_img') . $jobitem->job_img_1}}@else{{asset('img/common/no-image.gif')}}@endif" alt="写真"></p>
                                    </div>
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap"><img src="@if($jobitem->job_img_2){{$jobBaseUrl . config('fpath.job_sheet_img') . $jobitem->job_img_2}}@else{{asset('img/common/no-image.gif')}}@endif" alt="写真"></p>
                                    </div>
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap"><img src="@if($jobitem->job_img_3){{$jobBaseUrl . config('fpath.job_sheet_img') . $jobitem->job_img_3}}@else{{asset('img/common/no-image.gif')}}@endif" alt="写真"></p>
                                    </div>

                                </div>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">動画</div>
                            <div class="card-body">
                                <div oncontextmenu="return false;" class="form-group e-image-register-area">
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap">
                                            <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                                <source src="@if($jobitem->job_mov_1){{$jobBaseUrl . config('fpath.job_sheet_mov') . $jobitem->job_mov_1}}@endif" /></iframe>
                                            </video>
                                        </p>
                                    </div>
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap">
                                            <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                                <source src="@if($jobitem->job_mov_2){{$jobBaseUrl . config('fpath.job_sheet_mov') . $jobitem->job_mov_2}}@endif" /></iframe>
                                            </video>
                                        </p>
                                    </div>
                                    <div class="e-image-register-item">
                                        <p class="e-image-wrap">
                                            <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                                <source src="@if($jobitem->job_mov_3){{$jobBaseUrl . config('fpath.job_sheet_mov') . $jobitem->job_mov_3}}@endif" /></iframe>
                                            </video>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">掲載期間</div>
                            <div class="card-body">
                                <table class="job-create-table">
                                    <tr>
                                        <th>掲載開始日</th>
                                        <td>
                                            <p>
                                                @if(Session::get('data.JobSheet.pub_start_flag') === 0)
                                                最短で掲載
                                                @elseif(Session::get('data.JobSheet.pub_start_date') !== null)
                                                {{Session::get('data.JobSheet.pub_start_date')}}
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>掲載終了日</th>
                                        <td>
                                            <p>
                                                @if(Session::get('data.JobSheet.pub_end_flag') === 0)
                                                無期限で掲載
                                                @elseif(Session::get('data.JobSheet.pub_end_date') !== null)
                                                {{Session::get('data.JobSheet.pub_end_date')}}
                                                @endif
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">募集内容</div>
                            <div class="card-body">
                                <table class="job-create-table">
                                    <tr>
                                        <th>キャッチコピー</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_title')){{Session::get('data.JobSheet.job_title')}}@endif</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>紹介文</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_intro')){!! nl2br(e(Session::get('data.JobSheet.job_intro'))) !!}@endif</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>勤務先</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_office')){!! nl2br(e(Session::get('data.JobSheet.job_office'))) !!}@endif</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>住所</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_office_address')){!! nl2br(e(Session::get('data.JobSheet.job_office_address'))) !!}@endif</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>職種</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_type')){{Session::get('data.JobSheet.job_type')}}@endif</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>仕事内容</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_desc')){!! nl2br(e(Session::get('data.JobSheet.job_desc'))) !!}@endif</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>給与</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_salary')){!! nl2br(e(Session::get('data.JobSheet.job_salary'))) !!}@endif</p>
                                        </td>
                                    </tr>
                                    @if(Session::has('data.JobSheet.salary_increase'))
                                    <tr>
                                        <th>昇給・賞与</th>
                                        <td>
                                            <p>{!! nl2br(e(Session::get('data.JobSheet.salary_increase'))) !!}</p>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>応募資格</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_target')){!! nl2br(e(Session::get('data.JobSheet.job_target'))) !!}@endif</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>勤務時間</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_time')){!! nl2br(e(Session::get('data.JobSheet.job_time'))) !!}@endif</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>待遇・福利厚生</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_treatment')){!! nl2br(e(Session::get('data.JobSheet.job_treatment'))) !!}@endif</p>
                                        </td>
                                    </tr>
                                    @if(Session::has('data.JobSheet.remarks'))
                                    <tr>
                                        <th>その他</th>
                                        <td>
                                            <p>{!! nl2br(e(Session::get('data.JobSheet.remarks'))) !!}</p>
                                        </td>
                                    </tr>
                                    @endif
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
                                            <p>@if(Session::has('data.JobSheet.job_q1')){{Session::get('data.JobSheet.job_q1')}}@endif</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>質問２</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_q2')){{Session::get('data.JobSheet.job_q2')}}@endif</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>質問３</th>
                                        <td>
                                            <p>@if(Session::has('data.JobSheet.job_q3')){{Session::get('data.JobSheet.job_q3')}}@endif</p>
                                        </td>
                                    </tr>


                                </table>
                            </div>
                        </div> <!-- card -->
                        <div class="card">
                            <div class="card-header">企業データ</div>
                            <div class="card-body">
                                <table class="job-create-table">
                                    @if(Auth::guard('employer')->user()->company->cname)
                                    <tr>
                                        <th>会社名</th>
                                        <td>
                                            <p>{{Auth::guard('employer')->user()->company->cname }}</p>
                                        </td>
                                    </tr>
                                    @endif
                                    @if(Auth::guard('employer')->user()->company->foundation)
                                    <tr>
                                        <th>設立</th>
                                        <td>
                                            <p>{{Auth::guard('employer')->user()->company->foundation }}</p>
                                        </td>
                                    </tr>
                                    @endif
                                    @if(Auth::guard('employer')->user()->company->postcode && Auth::guard('employer')->user()->company->prefecture && Auth::guard('employer')->user()->company->address)
                                    <tr>
                                        <th>本社所在地</th>
                                        <td>
                                            <p>{{Auth::guard('employer')->user()->company->cname }}</p>
                                        </td>
                                    </tr>
                                    @endif
                                    @if(Auth::guard('employer')->user()->company->postcode)
                                    <tr>
                                        <th>会社住所</th>
                                        <td>
                                            <p>〒{{Auth::guard('employer')->user()->company->postcode }}<br>
                                                {{Auth::guard('employer')->user()->company->prefecture }}<br>
                                                {{Auth::guard('employer')->user()->company->address }}<br>
                                            </p>
                                        </td>
                                    </tr>
                                    @endif
                                    @if(Auth::guard('employer')->user()->company->capital)
                                    <tr>
                                        <th>資本金</th>
                                        <td>
                                            <p>{{Auth::guard('employer')->user()->company->capital }}</p>
                                        </td>
                                    </tr>
                                    @endif
                                    @if(Auth::guard('employer')->user()->company->employee_number)
                                    <tr>
                                        <th>従業員数</th>
                                        <td>
                                            <p>{{Auth::guard('employer')->user()->company->employee_number }}</p>
                                        </td>
                                    </tr>
                                    @endif
                                    @if(Auth::guard('employer')->user()->company->description)
                                    <tr>
                                        <th>事業内容</th>
                                        <td>
                                            <p>{!! nl2br(e(Auth::guard('employer')->user()->company->description)) !!}</p>
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                                <p class="text-danger">※企業データは「企業データの編集」から変更できます。</p>
                            </div>
                        </div> <!-- card -->
                        <div class="form-group text-center">
                            <p class="mb-3">
                                @if($jobitem->status !== 2)
                                「この求人を登録する」ボタンを押すと掲載申請を行い、JOBCiNEMAで承認後に求人票が掲載されます
                                @else
                                「変更を確定する」ボタンを押すと掲載中の求人票の内容が変更されます<br>
                                変更後も掲載は続きます
                                @endif
                            </p>
                            <button type="submit" class="btn btn-dark">
                                @if($jobitem->status !== 2)
                                この求人を登録する
                                @else
                                変更を確定する
                                @endif
                            </button>
                            <a class="btn btn-outline-secondary" href="{{url("/company/jobs/create/step2/" . $jobitem->id . "?edit=1")}}">前に戻って修正する</a>
                        </div>
                        @if(Session::has('message'))
                        <div class="alert alert-success">
                            {{ Session::get('message') }}
                        </div>
                        @endif
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
