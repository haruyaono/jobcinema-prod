@extends('layouts.employer_mypage_master')

@section('title', '求人票の確認 | JOB CiNEMA')
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
    

    <div class="col-12 col-lg-10 col-md-10 col-sm-12 mr-auto ml-auto px-0">
    <div class="text-center pb-3 mb-4">
        作成された求人票の内容を確認できます。
    </div>
        <div class="card">
                <div class="card-header">募集カテゴリ</div>
                <div class="card-body">
                    <table class="job-create-table">
                        <tr>
                            <th>雇用形態</th>
                            <td>
                                <p>
                                    {{App\Job\Categories\Category::find($job->categories()->wherePivot('slug', 'status')->first()->id)->name}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>募集職種</th>
                            <td>
                                <p>
                                {{App\Job\Categories\Category::find($job->categories()->wherePivot('slug', 'type')->first()->id)->name}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>勤務地エリア</th>
                            <td>
                                <p>
                                {{App\Job\Categories\Category::find($job->categories()->wherePivot('slug', 'area')->first()->id)->name}}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>最低給与</th>
                            <td>
                                @foreach($job->categories()->wherePivot('slug', 'salary')->get() as $category)
                                    <p>{{App\Job\Categories\Category::find($category->id)->parent->name}}: {{App\Job\Categories\Category::find($category->id)->name}}</p>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>最低勤務日数</th>
                            <td>
                                <p>
                                {{App\Job\Categories\Category::find($job->categories()->wherePivot('slug', 'date')->first()->id)->name}}
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
                            <p class="e-image-wrap"><img src="@if(config('app.env') == 'production' && $job->job_img){{config('app.s3_url')}}{{$job->job_img}}@elseif($job->job_img) {{$job->job_img}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真"></p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap"><img src="@if(config('app.env') == 'production' && $job->job_img2){{config('app.s3_url')}}{{$job->job_img2}}@elseif($job->job_img2) {{$job->job_img2}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真"></p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap"><img src="@if(config('app.env') == 'production' && $job->job_img3){{config('app.s3_url')}}{{$job->job_img3}}@elseif($job->job_img3) {{$job->job_img3}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真"></p>
                        </div>
                    
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">動画</div>
                <div class="card-body">
                    <div  oncontextmenu="return false;" class="form-group e-image-register-area">
                        <div class="e-image-register-item">
                            <p class="e-image-wrap">
                                <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                    <source src="@if(config('app.env') == 'production' && $job->job_mov){{config('app.s3_url')}}{{$job->job_mov}}@elseif($job->job_mov) {{$job->job_mov}}@endif"/></iframe>
                                </video>
                            </p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap">
                                <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                    <source src="@if(config('app.env') == 'production' && $job->job_mov2){{config('app.s3_url')}}{{$job->job_mov2}}@elseif($job->job_mov2) {{$job->job_mov2}}@endif"/></iframe>
                                </video>
                            </p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap">
                                <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                    <source src="@if(config('app.env') == 'production' && $job->job_mov3){{config('app.s3_url')}}{{$job->job_mov3}}@elseif($job->job_mov3) {{$job->job_mov3}}@endif"/></iframe>
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
                                    @if($job->pub_start)
                                        {{$job->pub_start}}
                                    @endif
                                </p>
                            </td>
                        </tr>
                        <tr>
                        <th>掲載終了日</th>
                            <td>
                                <p>
                                    @if($job->pub_end)
                                        {{$job->pub_end}}
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
                                <p>@if($job->job_title){{$job->job_title}}@endif</p>
                            </td>
                        </tr>
                        <tr>
                            <th>紹介文</th>
                            <td>
                                <p>@if($job->job_intro){!! nl2br(e($job->job_intro)) !!}@endif</p>
                            </td>
                        </tr>
                        <tr>
                            <th>勤務先</th>
                            <td>
                                <p>@if($job->job_office){!! nl2br(e($job->job_office)) !!}@endif</p>
                            </td>
                        </tr>
                        <tr>
                        <th>住所</th>
                            <td>
                                <p>@if($job->job_office_address){!! nl2br(e($job->job_office_address)) !!}@endif</p>
                            </td>
                        </tr>
                        <tr>
                            <th>職種</th>
                            <td>
                                <p>@if($job->job_type){{$job->job_type}}@endif</p>
                            </td>
                        </tr>
                        <tr>
                            <th>仕事内容</th>
                            <td>
                                <p>@if($job->job_desc){!! nl2br(e($job->job_desc)) !!}@endif</p>
                            </td>
                        </tr>
                        <tr>
                            <th>給与</th>
                            <td>
                                <p>@if($job->job_hourly_salary){!! nl2br(e($job->job_hourly_salary)) !!}@endif</p>
                            </td>
                        </tr>
                        @if(Session::has('data2.salary_increase'))
                            <tr>
                                <th>昇給・賞与</th>
                                <td>
                                    <p>@if($job->salary_increase){!! nl2br(e($job->salary_increase)) !!}@endif</p>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th>応募資格</th>
                            <td>
                                <p>@if($job->job_target){!! nl2br(e($job->job_target)) !!}@endif</p>
                            </td>
                        </tr>
                        <tr>
                            <th>勤務時間</th>
                            <td>
                                <p>@if($job->job_time){!! nl2br(e($job->job_time)) !!}@endif</p>
                            </td>
                        </tr>
                        <tr>
                            <th>待遇・福利厚生</th>
                            <td>
                                <p>@if($job->job_treatment){!! nl2br(e($job->job_treatment)) !!}@endif</p>
                            </td>
                        </tr>
                        @if(Session::has('data2.remarks'))
                            <tr>
                                <th>その他</th>
                                <td>
                                    <p>@if($job->remarks){!! nl2br(e($job->remarks)) !!}@endif</p>
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
                                <p>@if($job->job_q1){{$job->job_q1}}@endif</p>
                            </td>
                        </tr>
                        <tr>
                            <th>質問２</th>
                            <td>
                                <p>@if($job->job_q2){{$job->job_q2}}@endif</p>
                            </td>
                        </tr>
                        <tr>
                            <th>質問３</th>
                            <td>
                                <p>@if($job->job_q3){{$job->job_q3}}@endif</p>
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
              <a class="btn back-btn ml-3" href="javascript:void(0);" onClick="window.opener.location.reload(),window.close()"><i class="fas fa-reply mr-3"></i>閉じる</a>
            </div>
    </div>
</div> 
</div>  <!-- inner --> 
</section>
</div> <!-- main-wrap -->
@endsection

@section('footer')
  @component('components.employer.mypage_footer')
  @endcomponent
@endsection



