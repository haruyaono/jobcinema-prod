<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">求人番号 {{$job->id}}</h1>
<span><a href="javascript:void(0)" style="margin-left:10px;" onclick="window.close();">Back</a></span>
@stop

<!-- ページの内容を入力 -->
@section('content')
<div class="col-md-12">
    <div class="card">
            <div class="card-header h5">募集カテゴリ</div>
            <div class="card-body ">
                <table class="admin-job-detail-table">
                    <tr>
                        <th>雇用形態</th>
                        <td>
                            <p>{{$job->categories()->wherePivot('slug', 'status')->first() !== null ? $job->categories()->wherePivot('slug', 'status')->first()->name : ''}}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>募集職種</th>
                        <td>
                            <p>{{$job->categories()->wherePivot('slug', 'type')->first() !== null ? $job->categories()->wherePivot('slug', 'type')->first()->name : ''}}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>勤務地エリア</th>
                        <td>
                            <p>{{$job->categories()->wherePivot('slug', 'area')->first() !== null ? $job->categories()->wherePivot('slug', 'area')->first()->name : ''}}</p>
                        </td>
                    </tr>
                    <tr>
                        <th>最低時給</th>
                        <td>
                            @if($job->categories()->wherePivot('slug', 'salary')->get() !== null)
                                @foreach($job->categories()->wherePivot('slug', 'salary')->get() as $category)
                                <p>{{$category->parent->name}}: {{$category->name}}</p>
                                @endforeach

                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>最低勤務日数</th>
                        <td>
                            <p>{{$job->categories()->wherePivot('slug', 'date')->first() !== null ? $job->categories()->wherePivot('slug', 'date')->first()->name : ''}}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div> <!-- card --> 
        <div class="card">
            <div class="card-header h5">写真/画像</div>
            <div class="card-body">
                <div class="form-group admin-job-image-area cf">
                    <div class="admin-job-image-item">
                        <p class="admin-image-wrap"><img src="@if(config('app.env') == 'production' && $job->job_img){{config('app.s3_url')}}{{$job->job_img}}@elseif($job->job_img) {{$job->job_img}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真"></p>
                    </div>
                    <div class="admin-job-image-item">
                        <p class="admin-image-wrap"><img src="@if(config('app.env') == 'production' && $job->job_img2){{config('app.s3_url')}}{{$job->job_img2}}@elseif($job->job_img2){{$job->job_img2}}@else{{asset('uploads/images/no-image.gif')}}@endif" alt="写真"></p>
                    </div>
                    <div class="admin-job-image-item">
                        <p class="admin-image-wrap"><img src="@if(config('app.env') == 'production' && $job->job_img3){{config('app.s3_url')}}{{$job->job_img3}}@elseif($job->job_img3){{$job->job_img3}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真"></p>
                    </div>
                
                </div>
            </div>
        </div> <!-- card --> 
        <div class="card">
            <div class="card-header h5">動画</div>
            <div class="card-body">
                <div  oncontextmenu="return false;" class="form-group admin-job-image-area cf">
                    <div class="admin-job-image-item">
                        <p class="admin-image-wrap">
                            <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                <source src="@if(config('app.env') == 'production' && $job->job_mov){{config('app.s3_url')}}{{$job->job_mov}}@elseif($job->job_mov){{$job->job_mov}}@endif"/></iframe>
                            </video>
                        </p>
                    </div>
                    <div class="admin-job-image-item">
                        <p class="admin-image-wrap">
                            <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                <source src="@if(config('app.env') == 'production' && $job->job_mov2){{config('app.s3_url')}}{{$job->job_mov2}}@elseif($job->job_mov2){{$job->job_mov2}}@endif"/></iframe>
                            </video>
                        </p>
                    </div>
                    <div class="admin-job-image-item">
                        <p class="admin-image-wrap">
                            <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                <source src="@if(config('app.env') == 'production' && $job->job_mov3){{config('app.s3_url')}}{{$job->job_mov3}}@elseif($job->job_mov3){{$job->job_mov3}}@endif"/></iframe>
                            </video>
                        </p>
                    </div>
                
                </div>
            </div>
        </div> <!-- card --> 
        <div class="card mt-3">
            <div class="card-header h5">掲載期間</div>
            <div class="card-body">
                <table class="admin-job-detail-table">
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
            <div class="card-header h5">募集内容</div>
            <div class="card-body">
                <table class="admin-job-detail-table">
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
                        <th>勤務先名</th>
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
                    <tr>
                        <th>昇給・賞与</th>
                        <td>
                            <p>@if($job->salary_increase){!! nl2br(e($job->salary_increase)) !!}@endif</p>
                        </td>
                    </tr>
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
                    <tr>
                        <th>その他</th>
                        <td>
                            <p>@if($job->remarks){!! nl2br(e($job->remarks)) !!}@endif</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div> <!-- card --> 
        <div class="card">
            <div class="card-header h5">企業から求職者への質問</div>
            <div class="card-body">
                <table class="admin-job-detail-table">
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
                <div class="card-header h5">企業データ</div>
                <div class="card-body">
                    <table class="admin-job-detail-table">
                        @if($job->company->cname)
                        <tr>
                            <th>会社名</th>
                            <td>
                                <p><a href="{{route('admin.company.detail',[$job->company->id])}}">{{$job->company->cname }}</a></p>
                            </td>
                        </tr>
                        @endif
                        @if($job->company->foundation)
                        <tr>
                            <th>設立</th>
                            <td>
                                <p>{{$job->company->foundation }}</p>
                            </td>
                        </tr>
                        @endif
                        @if($job->company->postcode && $job->company->prefecture && $job->company->address)
                        <tr>
                            <th>本社所在地</th>
                            <td>
                                <p>{{$job->company->cname }}</p>
                            </td>
                        </tr>
                        @endif
                        @if($job->company->postcode)
                        <tr>
                            <th>会社住所</th>
                            <td>
                                <p>〒{{$job->company->postcode }}<br>
                                {{$job->company->prefecture }}<br>
                                {{$job->company->address }}<br>
                                </p>
                            </td>
                        </tr>
                        @endif
                        @if($job->company->capital)
                        <tr>
                            <th>資本金</th>
                            <td>
                                <p>{{$job->company->capital }}</p>
                            </td>
                        </tr>
                        @endif
                        @if($job->company->employee_number)
                        <tr>
                            <th>従業員数</th>
                            <td>
                                <p>{{$job->company->employee_number }}</p>
                            </td>
                        </tr>
                        @endif
                        @if($job->company->description)
                        <tr>
                            <th>事業内容</th>
                            <td>
                                <p>{!! nl2br(e($job->company->description)) !!}</p>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div> <!-- card --> 
       
</div>


@stop
<!-- 読み込ませるJSを入力 -->
@section('js')
   
@stop