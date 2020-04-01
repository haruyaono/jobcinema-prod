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
        <form  action="{{route('job.draftOrStep2', [$job->id]) }}" class="job-create" method="POST" enctype="multipart/form-data">@csrf
            <div class="card">
                <div class="card-header">募集カテゴリを選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                    <table class="job-create-table jobcat-edit-create-table">
                        <tr>
                            <th>雇用形態</th>
                            <td>@if(Session::has('edit_cat_list.status')){{App\Models\StatusCat::find(Session::get('edit_cat_list.status'))->name}}@else{{App\Models\StatusCat::find($job->status_cat_id)->name}}@endif</td>
                            <td><a href="{{route('job.category.edit', [$job->id, 'category'=>'status'])}}">変更する</a></td>
                        </tr>
                        <tr>
                            <th>職種</th>
                            <td>@if(Session::has('edit_cat_list.type')){{App\Models\TypeCat::find(Session::get('edit_cat_list.type'))->name}}@else{{App\Models\TypeCat::find($job->type_cat_id)->name}}@endif</td>
                            <td><a href="{{route('job.category.edit', [$job->id, 'category'=>'type'])}}">変更する</a></td>
                        </tr>
                        <tr>
                            <th>勤務地エリア</th>
                            <td>@if(Session::has('edit_cat_list.area')){{App\Models\AreaCat::find(Session::get('edit_cat_list.area'))->name}}@else{{App\Models\AreaCat::find($job->area_cat_id)->name}}@endif</td>
                            <td><a href="{{route('job.category.edit', [$job->id, 'category'=>'area'])}}">変更する</a></td>
                        </tr>
                        <tr>
                            <th>最低時給</th>
                            <td>@if(Session::has('edit_cat_list.hourly_salary')){{App\Models\HourlySalaryCat::find(Session::get('edit_cat_list.hourly_salary'))->name}}@else{{App\Models\HourlySalaryCat::find($job->hourly_salary_cat_id)->name}}@endif</td>
                            <td><a href="{{route('job.category.edit', [$job->id, 'category'=>'hourly_salary'])}}">変更する</a></td>
                        </tr>
                        <tr>
                            <th>最低勤務日数</th>
                            <td>@if(Session::has('edit_cat_list.date')){{App\Models\DateCat::find(Session::get('edit_cat_list.date'))->name}}@else{{App\Models\DateCat::find($job->date_cat_id)->name}}@endif</td>
                            <td><a href="{{route('job.category.edit', [$job->id, 'category'=>'date'])}}">変更する</a></td>
                        </tr>
                    </table>
                </div>
            </div> <!-- card --> 
            
            <div class="card">
                <div class="card-header">写真/画像（メイン写真は必ず登録してください）<span class="text-danger">＊</span></div>
                <div class="card-body">
                    <div class="form-group e-image-register-area">
                        <div class="e-image-register-item">
                            <p class="e-image-wrap"><img src="@if($job->job_img != null && Session::has('edit_image_path_list.main') == false ) {{$job->job_img}}@elseif(Session::get('edit_image_path_list.main') != $job->job_img && Session::get('edit_image_path_list.main') != ''){{Session::get('edit_image_path_list.main')}}@elseif(Session::get('edit_image_path_list.main')  == ''){{asset('uploads/images/no-image.gif')}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真を登録してください"></p>
                            <p class="text-center">
                                <a class="btn-gradient-3d-orange" href="{{route('main.image.get', [$job->id])}}" target="_blank">メイン写真を登録</a>
                            </p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap"><img src="@if($job->job_img2 != null && Session::has('edit_image_path_list.sub1') == false ) {{$job->job_img2}}@elseif(Session::get('edit_image_path_list.sub1') != $job->job_img2 && Session::get('edit_image_path_list.sub1') != ''){{Session::get('edit_image_path_list.sub1')}}@elseif(Session::get('edit_image_path_list.sub1')  == ''){{asset('uploads/images/no-image.gif')}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真を登録してください"></p>
                            <p class="text-center">
                            <a class="btn-gradient-3d-orange" href="{{route('sub.image1.get', [$job->id])}}" target="_blank">サブ写真を登録</a>
                            </p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap"><img src="@if($job->job_img3 != null && Session::has('edit_image_path_list.sub2') == false ) {{$job->job_img3}}@elseif(Session::get('edit_image_path_list.sub2') != $job->job_img2 && Session::get('edit_image_path_list.sub2') != ''){{Session::get('edit_image_path_list.sub2')}}@elseif(Session::get('edit_image_path_list.sub2')  == ''){{asset('uploads/images/no-image.gif')}}@else {{asset('uploads/images/no-image.gif')}}@endif" alt="写真を登録してください"></p>
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
                                <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                    <source src="@if($job->job_mov != null && Session::has('edit_movie_path_list.main') == false ){{$job->job_mov}}@elseif(Session::get('edit_movie_path_list.main') != $job->job_mov && Session::get('edit_movie_path_list.main') != ''){{Session::get('edit_movie_path_list.main')}}@elseif(Session::get('edit_movie_path_list.main')  == '')@else @endif"/></iframe>
                                </video>
                            </p>
                            <p class="text-center">
                                <a class="btn-gradient-3d-blue" href="{{route('main.movie.get', [$job->id])}}" target="_blank">メイン動画を登録</a>
                            </p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap">
                                <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                    <source src="@if($job->job_mov2 != null && Session::has('edit_movie_path_list.sub1') == false ) {{$job->job_mov2}}@elseif(Session::get('edit_movie_path_list.sub1') != $job->job_mov2 && Session::get('edit_movie_path_list.sub1') != ''){{Session::get('edit_movie_path_list.sub1')}}@elseif(Session::get('edit_movie_path_list.sub1')  == '')@else @endif"/></iframe>
                                </video>
                            </p>
                            <p class="text-center">
                                <a class="btn-gradient-3d-blue" href="{{route('sub.movie1.get', [$job->id])}}" target="_blank">サブ動画を登録</a>
                            </p>
                        </div>
                        <div class="e-image-register-item">
                            <p class="e-image-wrap">
                                <video controls controlsList="nodownload" preload="none" playsinline width="100%" height="100%">
                                    <source src="@if($job->job_mov3 != null && Session::has('edit_movie_path_list.sub2') == false ) {{$job->job_mov3}}@elseif(Session::get('edit_movie_path_list.sub2') != $job->job_mov3 && Session::get('edit_movie_path_list.sub2') != ''){{Session::get('edit_movie_path_list.sub2')}}@elseif(Session::get('edit_movie_path_list.sub2')  == '')@else @endif"/></iframe>
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
                                <input id="shortest" type="radio" name="pub_start" value="最短で掲載" checked {{ old('pub_start') == '最短で掲載' ? 'checked' : ''}} @if(Session::has('data2.pub_start') && !old('pub_start')) {{Session::get('data2.pub_start') == '最短で掲載' ? 'checked' : ''}}@endif @if(Session::has('data2.pub_start')==false && !old('pub_start')){{$job->pub_start == '最短で掲載' ? 'checked' : ''}}@else @endif onClick="pubstartflg0(this.checked);">
                                <label for="shortest">最短で掲載</label><br>
                                <input id="start_specified"  type="radio"  name="pub_start" value="start_specified" {{ old('pub_start') == 'start_specified' ? 'checked' : ''}} @if(Session::has('data2.pub_start') && !old('pub_start')) {{Session::get('data2.pub_start') == 'start_specified' ? 'checked' : ''}}@endif @if(Session::has('data2.pub_start')==false && !old('pub_start')){{$job->pub_start != '最短で掲載' ? 'checked' : ''}} @endif onClick="pubstartflg1(this.checked);">
                                <label for="start_specified">掲載開始日を指定</label><input class="ml-2" id="start_specified_date" type="text"  name="start_specified_date" disabled="disabled" value="{{old('start_specified_date')}} @if(!old('start_specified_date')) {{Session::get('data2.start_specified_date')}}@endif @if(!old('start_specified_date') && Session::has('data2.start_specified_date')==false){{$job->pub_start == '最短で掲載' ? '':$job->pub_start}}@endif" required><br>
                            </td>
                        </tr>
                        <tr>
                        <th>掲載終了日</th>
                            <td>
                                <input id="not_specified" type="radio" name="pub_end" value="無期限で掲載" checked {{ old('pub_end') == '無期限で掲載' ? 'checked' : ''}} @if(Session::has('data2.pub_end') && !old('pub_end')) {{Session::get('data2.pub_end') == '無期限で掲載' ? 'checked' : ''}}@elseif(Session::has('data2.pub_end')==false && !old('pub_end')){{$job->pub_end == '無期限で掲載' ? 'checked' : ''}}@else @endif onClick="pubendflg0(this.checked);">
                                <label for="not_specified">無期限で掲載</label><br>
                                <input id="end_specified" type="radio" name="pub_end" value="end_specified" {{ old('pub_end') == 'end_specified' ? 'checked' : ''}} @if(Session::has('data2.pub_end') && !old('pub_end')) {{Session::get('data2.pub_end') == 'end_specified' ? 'checked' : ''}}@endif @if(Session::has('data2.pub_end')==false && !old('pub_end')){{$job->pub_end != '無期限で掲載' ? 'checked' : ''}} @endif onClick="pubendflg1(this.checked);">
                                <label for="end_specified">掲載終了日を指定</label><input class="ml-2" id="end_specified_date" type="text" name ="end_specified_date" disabled="disabled" value="{{old('end_specified_date')}} @if(!old('end_specified_date')) {{Session::get('data2.end_specified_date')}}@endif @if(!old('end_specified_date') && Session::has('data2.end_specified_date')==false){{$job->pub_end == '無期限で掲載' ? '':$job->pub_end}}@endif" required><br>
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
                            <input type="text" v-model="typedText1" name="job_title" class="form-control {{ $errors->has('job_title') ? 'is-invalid' : ''}}" value="{{ old('job_title') }}@if(!old('job_title') && Session::has('data2.job_title')){{Session::get('data2.job_title')}}@elseif(!old('job_title') && Session::has('data2.job_title')==false){{$job->job_title}}@else @endif">
                            </td>
                        </tr>
                        <tr>
                        <th>紹介文<span class="text-danger">（必須）</span>
                            <p class="chara-count" v-bind:class="{'text-danger': charaCount2 > 250 }">(@{{ charaCount2 }}/250字)</p>
                        </th>
                            <td>
                            <textarea v-model="typedText2" name="job_intro" class="form-control {{ $errors->has('job_intro') ? 'is-invalid' : ''}}">{{ old('job_intro') }}@if(!old('job_intro') && Session::has('data2.job_intro')){{Session::get('data2.job_intro')}}@elseif(!old('job_intro') && Session::has('data2.job_intro')==false){{$job->job_intro}}@else @endif</textarea>
                            </td>
                        </tr>
                        <tr>
                        <th>勤務先<span class="text-danger">（必須）</span></th>
                            <td>
                            <p class="text-danger mb-2">勤務する会社名（支店名）・店舗名などご入力ください</p>
                            <textarea type="text" name="job_office" class="form-control {{ $errors->has('job_office') ? 'is-invalid' : ''}}" >{{ old('job_office') }}@if(!old('job_office') && Session::has('data2.job_office')){{Session::get('data2.job_office')}}@elseif(!old('job_office') && Session::has('data2.job_office')==false){{$job->job_office}}@elseif(!old('job_office') && Session::has('data2.job_office')==false && $job->job_office==""){{auth('employer')->user()->company->cname}}@else @endif</textarea>
                            </td>
                        </tr>
                        <tr>
                        <th>住所<span class="text-danger">（必須）</span></th>
                            <td>
                            <p class="text-danger mb-2">勤務地が複数ある場合には複数ご入力ください</p>
                            <textarea type="text" name="job_office_address" class="form-control {{ $errors->has('job_office_address') ? 'is-invalid' : ''}}" >{{ old('job_office_address') }}@if(!old('job_office_address') && Session::has('data2.job_office_address')){{Session::get('data2.job_office_address')}}@elseif(!old('job_office_address') && Session::has('data2.job_office_address')==false){{$job->job_office_address}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                            <th>職種<span class="text-danger">（必須）</span></th>
                            <td>
                                <input type="text" name="job_type" class="form-control {{ $errors->has('job_type') ? 'is-invalid' : ''}}" value="{{ old('job_type') }}@if(!old('job_type') && Session::has('data2.job_type')){{Session::get('data2.job_type')}}@elseif(!old('job_type') && Session::has('data2.job_type')==false){{$job->job_type}}@else @endif">
                            </td>
                        </tr>
                        <tr>
                        <th>仕事内容<span class="text-danger">（必須）</span>
                            <p class="chara-count" v-bind:class="{'text-danger': charaCount3 > 700 }">(@{{ charaCount3 }}/700字)</p>
                        </th>
                            <td>
                            <p class="text-danger mb-2">具体的な仕事の内容、業務の範囲などをご入力ください</p>
                            <textarea v-model="typedText3" type="text" name="job_desc" class="form-control {{ $errors->has('job_desc') ? 'is-invalid' : ''}}" >{{ old('job_desc') }}@if(!old('job_desc') && Session::has('data2.job_desc')){{Session::get('data2.job_desc')}}@elseif(!old('job_desc') && Session::has('data2.job_desc')==false){{$job->job_desc}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>給与<span class="text-danger">（必須）</span></th>
                            <td>
                            <textarea type="text" name="job_hourly_salary" class="form-control {{ $errors->has('job_hourly_salary') ? 'is-invalid' : ''}}" >{{ old('job_hourly_salary') }}@if(!old('job_hourly_salary') && Session::has('data2.job_hourly_salary')){{Session::get('data2.job_hourly_salary')}}@elseif(!old('job_hourly_salary') && Session::has('data2.job_hourly_salary')==false){{$job->job_hourly_salary}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>昇給・賞与</th>
                            <td>
                            <textarea type="text" name="salary_increase" class="form-control {{ $errors->has('salary_increase') ? 'is-invalid' : ''}}" >{{ old('salary_increase') }}@if(!old('salary_increase') && Session::has('data2.salary_increase')){{Session::get('data2.salary_increase')}}@elseif(!old('salary_increase') && Session::has('data2.salary_increase')==false){{$job->salary_increase}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>応募資格<span class="text-danger">（必須）</span></th>
                            <td>
                            <textarea type="text" name="job_target" class="form-control {{ $errors->has('job_target') ? 'is-invalid' : ''}}" >{{ old('job_target') }}@if(!old('job_target') && Session::has('data2.job_target')){{Session::get('data2.job_target')}}@elseif(!old('job_target') && Session::has('data2.job_target')==false){{$job->job_target}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>勤務時間<span class="text-danger">（必須）</span></th>
                            <td>
                            <textarea type="text" name="job_time" class="form-control {{ $errors->has('job_time') ? 'is-invalid' : ''}}" >{{ old('job_time') }}@if(!old('job_time') && Session::has('data2.job_time')){{Session::get('data2.job_time')}}@elseif(!old('job_time') && Session::has('data2.job_time')==false){{$job->job_time}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>待遇・福利厚生<span class="text-danger">（必須）</span></th>
                        <td>
                            <p class="text-danger mb-2">各種保険や交通費支給などご入力ください</p>
                            <textarea type="text" name="job_treatment" class="form-control {{ $errors->has('job_treatment') ? 'is-invalid' : ''}}" >{{ old('job_treatment') }}@if(!old('job_treatment') && Session::has('data2.job_treatment')){{Session::get('data2.job_treatment')}}@elseif(!old('job_treatment') && Session::has('data2.job_treatment')==false){{$job->job_treatment}}@else @endif</textarea>
                        </td>
                        </tr>
                        <tr>
                        <th>その他
                        <p class="chara-count" v-bind:class="{'text-danger': charaCount4 > 1300 }">(@{{ charaCount4 }}/1300字)</p>
                        </th>
                        <td>
                            <p class="text-danger mb-2">その他に定める事や応募者への連絡事項など、ご自由にご入力ください</p>
                            <textarea v-model="typedText4" type="text" name="remarks" class="form-control {{ $errors->has('remarks') ? 'is-invalid' : ''}}" >{{ old('remarks') }}@if(!old('remarks') && Session::has('data2.remarks')){{Session::get('data2.remarks')}}@elseif(!old('remarks') && Session::has('data2.remarks')==false){{$job->remarks}}@else @endif</textarea>
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
                            <input type="text" name="job_q1" class="form-control {{ $errors->has('job_q1') ? 'is-invalid' : ''}}" value="{{ old('job_q1') }}@if(!old('job_q1') && Session::has('data2.job_q1')){{Session::get('data2.job_q1')}}@elseif(!old('job_q1') && Session::has('data2.job_q1')==false){{$job->job_q1}}@else @endif">
                            </td>
                        </tr>
                        <tr>
                            <th>質問２</th>
                            <td>
                            <input type="text" name="job_q2" class="form-control {{ $errors->has('job_q2') ? 'is-invalid' : ''}}" value="{{ old('job_q2') }}@if(!old('job_q2') && Session::has('data2.job_q2')){{Session::get('data2.job_q2')}}@elseif(!old('job_q2') && Session::has('data2.job_q2')==false){{$job->job_q2}}@else @endif">
                            </td>
                        </tr>
                        <tr>
                            <th>質問３</th>
                            <td>
                            <input type="text" name="job_q3" class="form-control {{ $errors->has('job_q3') ? 'is-invalid' : ''}}" value="{{ old('job_q3') }}@if(!old('job_q3') && Session::has('data2.job_q3')){{Session::get('data2.job_q3')}}@elseif(!old('job_q3') && Session::has('data2.job_q3')==false){{$job->job_q3}}@else @endif">
                            </td>
                        </tr>
                    </table>
                </div>
        </div> <!-- card --> 
        <div class="form-group text-center">
            <input type="submit" class="btn btn-dark" name="storestep2" value="確認画面へ進む">
            <input type="submit" class="btn btn-outline-secondary" name="draft" value="一時保存する">
                
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




