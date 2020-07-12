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
        @if(count($errors) > 0 || Session::has('message_danger'))
        <div class="alert alert-danger">
            <strong><i class="fas fa-exclamation-circle"></i>エラー</strong><br>
            <ul class="list-unstyled">
                @if(Session::has('message_danger'))
                <li>{{ Session::get('message_danger') }}</li>
                @endif
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(Session::has('message_success'))
            <div class="alert alert-success">
                {{ Session::get('message_success') }}
            </div>
        @endif
        <form id="jobsheet-create-form" action="" class="job-create jobSaveForm" method="POST" enctype="multipart/form-data">@csrf
            <div class="card">
                <div class="card-header">募集カテゴリを選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                    <table class="job-create-table jobcat-edit-create-table">
                        <tr>
                            <th>雇用形態</th>
                            <td>
                                @if(Session::has('data.form.edit_category.cats_status.id')){{App\Job\Categories\Category::find(Session::get('data.form.edit_category.cats_status.id'))->name}}
                                @else
                                    @foreach($job->categories as $category)
                                        @if($category->parent->name == '雇用形態')
                                            {{App\Job\Categories\Category::find($category->id)->name}}
                                        @endif
                                    @endforeach
                               
                                @endif</td>
                            <td><a href="{{route('job.category.edit', [$job->id, 'category'=>'status'])}}" class="txt-blue-link">変更する</a></td>
                        </tr>
                        <tr>
                            <th>職種</th>
                            <td>
                                @if(Session::has('data.form.edit_category.cats_type.id')){{App\Job\Categories\Category::find(Session::get('data.form.edit_category.cats_type.id'))->name}}
                                @else
                                    @foreach($job->categories as $category)
                                        @if($category->parent->name == '職種')
                                            {{App\Job\Categories\Category::find($category->id)->name}}
                                        @endif
                                    @endforeach
                                @endif</td>
                            <td><a href="{{route('job.category.edit', [$job->id, 'category'=>'type'])}}" class="txt-blue-link">変更する</a></td>
                        </tr>
                        <tr>
                            <th>勤務地エリア</th>
                            <td>
                                @if(Session::has('data.form.edit_category.cats_area.id')){{App\Job\Categories\Category::find(Session::get('data.form.edit_category.cats_area.id'))->name}}
                                @else
                                    @foreach($job->categories as $category)
                                        @if($category->parent->name == 'エリア')
                                            {{App\Job\Categories\Category::find($category->id)->name}}
                                        @endif
                                    @endforeach
                                @endif</td>
                            <td><a href="{{route('job.category.edit', [$job->id, 'category'=>'area'])}}" class="txt-blue-link">変更する</a></td>
                        </tr>
                        <tr>
                            <th>最低給与</th>
                            <td>

                                @if($salaryList->has('session'))
                                    @foreach($salaryList['session'] as $salCat)
                                        <p>{{App\Job\Categories\Category::find($salCat['id'])->parent->name}}: {{App\Job\Categories\Category::find($salCat['id'])->name}}</p>
                                    @endforeach
                                @else
                                    @if($salaryList->has('saved'))
                                        @foreach($salaryList['saved'] as $pCat => $savSalCat) 
                                        <p>{{$savSalCat->parent->name}}: {{$savSalCat->name}}</p>
                                        @endforeach
                                    @endif
                                @endif</td>
                            <td><a href="{{route('job.category.edit', [$job->id, 'category'=>'salary'])}}" class="txt-blue-link">変更する</a></td>
                        </tr>
                        <tr>
                            <th>最低勤務日数</th>
                            <td>
                                @if(Session::has('data.form.edit_category.cats_date.id')){{App\Job\Categories\Category::find(Session::get('data.form.edit_category.cats_date.id'))->name}}
                                @else
                                    @foreach($job->categories as $category)
                                        @if($category->parent->name == '勤務日数')
                                            {{App\Job\Categories\Category::find($category->id)->name}}
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td><a href="{{route('job.category.edit', [$job->id, 'category'=>'date'])}}" class="txt-blue-link">変更する</a></td>
                        </tr>
                    </table>
                </div>
            </div> <!-- card --> 
            
            <div class="card">
                <div class="card-header">写真/画像（メイン写真は必ず登録してください）<span class="text-danger">＊</span></div>
                <div class="card-body">
                    <div class="form-group e-image-register-area">
                        <div class="e-image-register-item">
                            <p class="e-image-wrap"><img src="@if($job->job_img != null && Session::has('data.file.edit_image.main') == false ){{$jobImageBaseUrl.$job->job_img}}@elseif(Session::get('data.file.edit_image.main') != $job->job_img && Session::get('data.file.edit_image.main') != ''){{$jobImageBaseUrl.Session::get('data.file.edit_image.main')}}@elseif(Session::get('data.file.edit_image.main')  == ''){{asset('uploads/images/no-image.gif')}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真を登録してください" name="photo1" id="photo1"></p>
                            <p class="text-center">
                                <a class="btn-gradient-3d-orange" href="{{route('main.image.get', [$job->id])}}" target="_blank">メイン写真を登録</a>
                            </p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap"><img src="@if($job->job_img2 != null && Session::has('data.file.edit_image.sub1') == false ) {{$jobImageBaseUrl.$job->job_img2}}@elseif(Session::get('data.file.edit_image.sub1') != $job->job_img2 && Session::get('data.file.edit_image.sub1') != ''){{$jobImageBaseUrl.Session::get('data.file.edit_image.sub1')}}@elseif(Session::get('data.file.edit_image.sub1')  == ''){{asset('uploads/images/no-image.gif')}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真を登録してください" name="photo2" id="photo2"></p>
                            <p class="text-center">
                                <a class="btn-gradient-3d-orange" href="{{route('sub.image1.get', [$job->id])}}" target="_blank">サブ写真を登録</a>
                            </p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap"><img src="@if($job->job_img3 != null && Session::has('data.file.edit_image.sub2') == false ) {{$jobImageBaseUrl.$job->job_img3}}@elseif(Session::get('data.file.edit_image.sub2') != $job->job_img2 && Session::get('data.file.edit_image.sub2') != ''){{$jobImageBaseUrl.Session::get('data.file.edit_image.sub2')}}@elseif(Session::get('data.file.edit_image.sub2')  == ''){{asset('uploads/images/no-image.gif')}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真を登録してください" name="photo3" id="photo3"></p>
                            <p class="text-center">
                                <a class="btn-gradient-3d-orange" href="{{route('sub.image2.get', [$job->id])}}" target="_blank">サブ写真を登録</a>
                            </p>
                        </div>
                    
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">動画 (職場の雰囲気や魅力を届けましょう）</div>
                <div class="card-body">
                    <div  oncontextmenu="return false;" class="form-group e-image-register-area">
                        <div class="e-image-register-item">
                            <p class="e-image-wrap">
                                <video src="@if($job->job_mov != null && Session::has('data.file.edit_movie.main') == false ){{$jobImageBaseUrl.$job->job_mov}}@elseif(Session::get('data.file.edit_movie.main') != $job->job_mov && Session::get('data.file.edit_movie.main') != ''){{$jobImageBaseUrl.Session::get('data.file.edit_movie.main')}}@elseif(Session::get('data.file.edit_movie.main')  == '')@else @endif" controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%" name="film1" id="film1">
                                </video>
                            </p>
                            <p class="text-center">
                                <a class="btn-gradient-3d-blue" href="{{route('main.movie.get', [$job->id])}}" target="_blank">メイン動画を登録</a>
                            </p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap">
                                <video src="@if($job->job_mov2 != null && Session::has('data.file.edit_movie.sub1') == false ) {{$jobImageBaseUrl.$job->job_mov2}}@elseif(Session::get('data.file.edit_movie.sub1') != $job->job_mov2 && Session::get('data.file.edit_movie.sub1') != ''){{$jobImageBaseUrl.Session::get('data.file.edit_movie.sub1')}}@elseif(Session::get('data.file.edit_movie.sub1')  == '')@else @endif" controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%" name="film2" id="film2">
                                </video>
                            </p>
                            <p class="text-center">
                                <a class="btn-gradient-3d-blue" href="{{route('sub.movie1.get', [$job->id])}}" target="_blank">サブ動画を登録</a>
                            </p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap">
                                <video src="@if($job->job_mov3 != null && Session::has('data.file.edit_movie.sub2') == false ) {{$jobImageBaseUrl.$job->job_mov3}}@elseif(Session::get('data.file.edit_movie.sub2') != $job->job_mov3 && Session::get('data.file.edit_movie.sub2') != ''){{$jobImageBaseUrl.Session::get('data.file.edit_movie.sub2')}}@elseif(Session::get('data.file.edit_movie.sub2')  == '')@else @endif" controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%" name="film3" id="film3">
                                </video>
                            </p>
                            <p class="text-center">
                                <a class="btn-gradient-3d-blue" href="{{route('sub.movie2.get', [$job->id])}}" target="_blank">サブ動画を登録</a>
                            </p>
                        </div>
                    
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">掲載期間<span class="text-danger">＊</span></div>
                <div class="card-body">
                    <table class="job-create-table">
                        <tr>
                            <th>掲載開始日</th>
                            <td> 
                                <input id="shortest" type="radio" name="pub_start" value="最短で掲載" checked {{ old('pub_start') == '最短で掲載' ? 'checked' : ''}} @if(Session::has('data.form.text.pub_start') && !old('pub_start')) {{Session::get('data.form.text.pub_start') == '最短で掲載' ? 'checked' : ''}}@elseif(Session::has('data.form.text.pub_start')==false && !old('pub_start')){{$job->pub_start == '最短で掲載' ? 'checked' : ''}}@else @endif>
                                <label for="shortest">最短で掲載</label><br>
                                <input id="start_specified"  type="radio"  name="pub_start" value="start_specified" {{ old('pub_start') == 'start_specified' ? 'checked' : ''}} @if(Session::has('data.form.text.pub_start') && !old('pub_start')) {{Session::get('data.form.text.pub_start') == 'start_specified' ? 'checked' : ''}}@elseif(Session::has('data.form.text.pub_start')==false && !old('pub_start')){{$job->pub_start != '最短で掲載' ? 'checked' : ''}}@endif>
                                <label for="start_specified">掲載開始日を指定</label><input class="ml-2" id="start_specified_date" type="text"  name="start_specified_date" disabled="disabled" value="{{old('start_specified_date')}} @if(!old('start_specified_date') && Session::has('data.form.text.start_specified_date')) {{Session::get('data.form.text.start_specified_date')}}@elseif(!old('start_specified_date') && Session::has('data.form.text.start_specified_date')==false){{$job->pub_start == '最短で掲載' ? '':$job->pub_start}}@endif" required><br>
                            </td>
                        </tr>
                        <tr>
                        <th>掲載終了日</th>
                            <td>
                                <input id="not_specified" type="radio" name="pub_end" value="無期限で掲載" checked {{ old('pub_end') == '無期限で掲載' ? 'checked' : ''}} @if(Session::has('data.form.text.pub_end') && !old('pub_end')) {{Session::get('data.form.text.pub_end') == '無期限で掲載' ? 'checked' : ''}}@elseif(Session::has('data.form.text.pub_end')==false && !old('pub_end')){{$job->pub_end == '無期限で掲載' ? 'checked' : ''}}@else @endif>
                                <label for="not_specified">無期限で掲載</label><br>
                                <input id="end_specified" type="radio" name="pub_end" value="end_specified" {{ old('pub_end') == 'end_specified' ? 'checked' : ''}} @if(Session::has('data.form.text.pub_end') && !old('pub_end')) {{Session::get('data.form.text.pub_end') == 'end_specified' ? 'checked' : ''}}@endif @if(Session::has('data.form.text.pub_end')==false && !old('pub_end')){{$job->pub_end != '無期限で掲載' ? 'checked' : ''}} @endif>
                                <label for="end_specified">掲載終了日を指定</label><input class="ml-2" id="end_specified_date" type="text" name ="end_specified_date" disabled="disabled" value="{{old('end_specified_date')}} @if(!old('end_specified_date') && Session::has('data.form.text.end_specified_date')) {{Session::get('data.form.text.end_specified_date')}}@elseif(!old('end_specified_date') && Session::has('data.form.text.end_specified_date')==false){{$job->pub_end == '無期限で掲載' ? '':$job->pub_end}}@endif" required><br>
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
                            <p class="chara-count" v-bind:class="{'text-danger': charaCount1 > 30 }">(@{{ charaCount1 }}/30字)</p>
                            </th>
                            <td>
                            <input type="text" id="job_title" v-model="typedText1" name="job_title" class="form-control {{ $errors->has('job_title') ? 'is-invalid' : ''}}" value="{{ old('job_title') }}@if(!old('job_title') && Session::has('data.form.text.job_title')){{Session::get('data.form.text.job_title')}}@elseif(!old('job_title') && Session::has('data.form.text.job_title')==false){{$job->job_title}}@else @endif">
                            </td>
                        </tr>
                        <tr>
                        <th>紹介文<span class="text-danger">（必須）</span>
                            <p class="chara-count" v-bind:class="{'text-danger': charaCount2 > 250 }">(@{{ charaCount2 }}/250字)</p>
                        </th>
                            <td>
                            <textarea v-model="typedText2" id="job_intro" name="job_intro" class="form-control {{ $errors->has('job_intro') ? 'is-invalid' : ''}}">{{ old('job_intro') }}@if(!old('job_intro') && Session::has('data.form.text.job_intro')){{Session::get('data.form.text.job_intro')}}@elseif(!old('job_intro') && Session::has('data.form.text.job_intro')==false){{$job->job_intro}}@else @endif</textarea>
                            </td>
                        </tr>
                        <tr>
                        <th>勤務先<span class="text-danger">（必須）</span></th>
                            <td>
                            <p class="text-danger mb-2">勤務する会社名（支店名）・店舗名などご入力ください</p>
                            <textarea type="text" name="job_office" class="form-control {{ $errors->has('job_office') ? 'is-invalid' : ''}}" >{{ old('job_office') }}@if(!old('job_office') && Session::has('data.form.text.job_office')){{Session::get('data.form.text.job_office')}}@elseif(!old('job_office') && Session::has('data.form.text.job_office')==false){{$job->job_office}}@elseif(!old('job_office') && Session::has('data.form.text.job_office')==false && $job->job_office==""){{auth('employer')->user()->company->cname}}@else @endif</textarea>
                            </td>
                        </tr>
                        <tr>
                        <th>住所<span class="text-danger">（必須）</span></th>
                            <td>
                            <p class="text-danger mb-2">勤務地が複数ある場合には複数ご入力ください</p>
                            <textarea type="text" name="job_office_address" class="form-control {{ $errors->has('job_office_address') ? 'is-invalid' : ''}}" >{{ old('job_office_address') }}@if(!old('job_office_address') && Session::has('data.form.text.job_office_address')){{Session::get('data.form.text.job_office_address')}}@elseif(!old('job_office_address') && Session::has('data.form.text.job_office_address')==false){{$job->job_office_address}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                            <th>職種<span class="text-danger">（必須）</span></th>
                            <td>
                                <input type="text" name="job_type" class="form-control {{ $errors->has('job_type') ? 'is-invalid' : ''}}" value="{{ old('job_type') }}@if(!old('job_type') && Session::has('data.form.text.job_type')){{Session::get('data.form.text.job_type')}}@elseif(!old('job_type') && Session::has('data.form.text.job_type')==false){{$job->job_type}}@else @endif">
                            </td>
                        </tr>
                        <tr>
                        <th>仕事内容<span class="text-danger">（必須）</span>
                            <p class="chara-count" v-bind:class="{'text-danger': charaCount3 > 700 }">(@{{ charaCount3 }}/700字)</p>
                        </th>
                            <td>
                            <p class="text-danger mb-2">具体的な仕事の内容、業務の範囲などをご入力ください</p>
                            <textarea id="job_desc" v-model="typedText3" type="text" name="job_desc" class="form-control {{ $errors->has('job_desc') ? 'is-invalid' : ''}}" >{{ old('job_desc') }}@if(!old('job_desc') && Session::has('data.form.text.job_desc')){{Session::get('data.form.text.job_desc')}}@elseif(!old('job_desc') && Session::has('data.form.text.job_desc')==false){{$job->job_desc}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>給与<span class="text-danger">（必須）</span></th>
                            <td>
                            <textarea type="text" name="job_hourly_salary" class="form-control {{ $errors->has('job_hourly_salary') ? 'is-invalid' : ''}}" >{{ old('job_hourly_salary') }}@if(!old('job_hourly_salary') && Session::has('data.form.text.job_hourly_salary')){{Session::get('data.form.text.job_hourly_salary')}}@elseif(!old('job_hourly_salary') && Session::has('data.form.text.job_hourly_salary')==false){{$job->job_hourly_salary}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>昇給・賞与</th>
                            <td>
                            <textarea type="text" name="salary_increase" class="form-control {{ $errors->has('salary_increase') ? 'is-invalid' : ''}}" >{{ old('salary_increase') }}@if(!old('salary_increase') && Session::has('data.form.text.salary_increase')){{Session::get('data.form.text.salary_increase')}}@elseif(!old('salary_increase') && Session::has('data.form.text.salary_increase')==false){{$job->salary_increase}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>応募資格<span class="text-danger">（必須）</span></th>
                            <td>
                            <textarea type="text" name="job_target" class="form-control {{ $errors->has('job_target') ? 'is-invalid' : ''}}" >{{ old('job_target') }}@if(!old('job_target') && Session::has('data.form.text.job_target')){{Session::get('data.form.text.job_target')}}@elseif(!old('job_target') && Session::has('data.form.text.job_target')==false){{$job->job_target}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>勤務時間<span class="text-danger">（必須）</span></th>
                            <td>
                            <textarea type="text" name="job_time" class="form-control {{ $errors->has('job_time') ? 'is-invalid' : ''}}" >{{ old('job_time') }}@if(!old('job_time') && Session::has('data.form.text.job_time')){{Session::get('data.form.text.job_time')}}@elseif(!old('job_time') && Session::has('data.form.text.job_time')==false){{$job->job_time}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>待遇・福利厚生<span class="text-danger">（必須）</span></th>
                        <td>
                            <p class="text-danger mb-2">各種保険や交通費支給などご入力ください</p>
                            <textarea type="text" name="job_treatment" class="form-control {{ $errors->has('job_treatment') ? 'is-invalid' : ''}}" >{{ old('job_treatment') }}@if(!old('job_treatment') && Session::has('data.form.text.job_treatment')){{Session::get('data.form.text.job_treatment')}}@elseif(!old('job_treatment') && Session::has('data.form.text.job_treatment')==false){{$job->job_treatment}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>その他
                        <p class="chara-count" v-bind:class="{'text-danger': charaCount4 > 1300 }">(@{{ charaCount4 }}/1300字)</p>
                        </th>
                        <td>
                            <p class="text-danger mb-2">その他に定める事や応募者への連絡事項など、ご自由にご入力ください</p>
                            <textarea id="remarks" v-model="typedText4" type="text" name="remarks" class="form-control {{ $errors->has('remarks') ? 'is-invalid' : ''}}" >{{ old('remarks') }}@if(!old('remarks') && Session::has('data.form.text.remarks')){{Session::get('data.form.text.remarks')}}@elseif(!old('remarks') && Session::has('data.form.text.remarks')==false){{$job->remarks}}@else @endif</textarea>
                        </td>
                        </tr>
                    </table>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">企業から求職者への質問<span class="text-danger"></span></div>
                <div class="card-body">
                    <table class="job-create-table">
                        <tr>
                            <th>質問１</th>
                            <td>
                            <input type="text" name="job_q1" class="form-control {{ $errors->has('job_q1') ? 'is-invalid' : ''}}" value="{{ old('job_q1') }}@if(!old('job_q1') && Session::has('data.form.text.job_q1')){{Session::get('data.form.text.job_q1')}}@elseif(!old('job_q1') && Session::has('data.form.text.job_q1')==false){{$job->job_q1}}@else @endif">
                            </td>
                        </tr>
                        <tr>
                            <th>質問２</th>
                            <td>
                            <input type="text" name="job_q2" class="form-control {{ $errors->has('job_q2') ? 'is-invalid' : ''}}" value="{{ old('job_q2') }}@if(!old('job_q2') && Session::has('data.form.text.job_q2')){{Session::get('data.form.text.job_q2')}}@elseif(!old('job_q2') && Session::has('data.form.text.job_q2')==false){{$job->job_q2}}@else @endif">
                            </td>
                        </tr>
                        <tr>
                            <th>質問３</th>
                            <td>
                            <input type="text" name="job_q3" class="form-control {{ $errors->has('job_q3') ? 'is-invalid' : ''}}" value="{{ old('job_q3') }}@if(!old('job_q3') && Session::has('data.form.text.job_q3')){{Session::get('data.form.text.job_q3')}}@elseif(!old('job_q3') && Session::has('data.form.text.job_q3')==false){{$job->job_q3}}@else @endif">
                            </td>
                        </tr>
                    </table>
                </div>
        </div> <!-- card --> 
        <div class="form-group text-center">
            <button type="button" onclick="submitAction('/company/job/store/step2/{{$job->id}}')" class="btn btn-dark" name="storestep2">確認画面へ進む</button>
            <button type="button" onclick="submitAction('/company/job/store/draft/{{$job->id}}')" class="btn btn-outline-secondary">一時保存する</button>
                
        </div>
        <div class="form-group text-center">
            <a class="btn back-btn ml-3" href="javascript:void(0);" onClick="window.opener.location.reload(),window.close()"><i class="fas fa-reply mr-3"></i>閉じる</a>
        </div>
    </form>
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


@section('js')
<script>
$(function() {
    $("#start_specified_date, #end_specified_date").datepicker({
        dateFormat: 'yy-mm-dd',
    });
});
</script>

@endsection

