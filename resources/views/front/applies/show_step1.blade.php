@extends('layouts.apply_form_master')

@section('title', '応募入力')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.apply_header')
@endcomponent
@endsection

@section('contents')
<div class="main-wrap">
  <section class="main-section">
    <div class="inner">
      <div class="pad">
        <h1 class="txt-h1">{{ $jobitem->job_office}}への応募情報の入力</h1>
        @if( Auth::guard('seeker')->check() )
        <section class="apply-job-info">
          <h2>応募先企業</h2>
          <div class="job-apply-item">
            <div class="d-flex">
              <div class="job-left only-pc">
                @if($jobitem->job_img_1)
                <img src="{{ config('app.s3_url') . config('jobcinema.jobitem_image_dir') . $jobitem->job_img_1 }}" style="width:100%;" alt="" />
                @else
                <img src="{{ asset('img/common/no-image.gif')}}" style="width:100%;" alt="No image">
                @endif
              </div>
              <div class="job-right">
                <table class="job-apply-table">
                  <tr>
                    <th>応募先企業</th>
                    <td>{{ $jobitem->company->cname}}</td>
                  </tr>
                  <tr>
                    <th>勤務先</th>
                    <td>{{ str_limit($jobitem->job_office, $limit = 40, $end = '...')}}</td>
                  </tr>
                  <tr>
                    <th>雇用形態</th>
                    <td>{{$jobitem->categories()->wherePivot('ancestor_slug', 'status')->first() !== null ? $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name : ''}}</td>
                  </tr>
                  <tr>
                    <th>職種</th>
                    <td>{{ str_limit($jobitem->job_type, $limit = 40, $end = '...')}}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </section>

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

        <form action="{{route('store.front.entry.step1', $jobitem)}}" method="POST">
          @csrf
          <section class="apply-job-form">
            <h2>応募する情報</h2>
            <table class="apply-job-form-table">
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">お名前（カナ）</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <div class="form-row m-0">
                    <input type="text" class="form-control col-5 col-ms-5 mr-3 {{ $errors->has('data.apply.last_name') ? 'is-invalid' : '' }}" name="data[apply][last_name]" value="@if(old('data.apply.last_name')){{old('data.apply.last_name')}}@elseif(Session::has('front.data.entry.last_name')){{Session::get('front.data.entry.last_name')}}@else{{Auth::guard('seeker')->user()->last_name}}@endif" required>
                    <input type="text" class="form-control col-5 col-ms-5 {{ $errors->has('data.apply.first_name') ? 'is-invalid' : '' }}" name="data[apply][first_name]" value="@if(old('data.apply.first_name')){{old('data.apply.first_name')}}@elseif(Session::has('front.data.entry.first_name')){{Session::get('front.data.entry.first_name')}}@else{{Auth::guard('seeker')->user()->first_name}}@endif" required>
                  </div>
                  <div class="text-danger">※ひらがな、もしくはカタカナでご入力下さい</div>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">連絡先電話番号</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <div class="form-row m-0">
                    <input class="form-control form-control col-3 col-md-3 {{ $errors->has('data.apply.phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="data[apply][phone1]" value="@if(old('data.apply.phone1')){{old('data.apply.phone1')}}@elseif(Session::has('front.data.entry.phone1')){{Session::get('front.data.entry.phone1')}}@else{{Auth::guard('seeker')->user()->profile->phone1}}@endif" required>
                    &nbsp;-&nbsp;
                    <input class="form-control form-control col-3 col-md-3 {{ $errors->has('data.apply.phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="data[apply][phone2]" value="@if(old('data.apply.phone2')){{old('data.apply.phone2')}}@elseif(Session::has('front.data.entry.phone2')){{Session::get('front.data.entry.phone2')}}@else{{Auth::guard('seeker')->user()->profile->phone2}}@endif" required>
                    &nbsp;-&nbsp;
                    <input class="form-control form-control col-3 col-md-3 {{ $errors->has('data.apply.phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="data[apply][phone3]" value="@if(old('data.apply.phone3')){{old('data.apply.phone3')}}@elseif(Session::has('front.data.entry.phone3')){{Session::get('front.data.entry.phone3')}}@else{{Auth::guard('seeker')->user()->profile->phone3}}@endif" required>
                  </div>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">年齢</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <div class="form-row m-0">
                    <input type="text" class="form-control w-25 {{ $errors->has('data.apply.age') ? 'is-invalid' : '' }}" name="data[apply][age]" value="@if(old('data.apply.age')){{old('data.apply.age')}}@elseif(Session::has('front.data.entry.age')){{Session::get('front.data.entry.age')}}@else{{Auth::guard('seeker')->user()->profile->age}}@endif" required> <span class="mt-2">　歳</span>
                  </div>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">性別</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <div class="form-group">
                    <input id="1" type="radio" name="data[apply][gender]" value="男性" @if(old('data.apply.gender')=='男性' ) checked @elseif(Session::get('front.data.entry.gender')=='男性' ) checked @elseif(Auth::guard('seeker')->user()->profile->gender == "男性") checked @endif><label for="1">男性</label>
                    <input id="2" type="radio" name="data[apply][gender]" value="女性" @if(old('data.apply.gender')=='女性' ) checked @elseif(Session::get('front.data.entry.gender')=='女性' ) checked @elseif(Auth::guard('seeker')->user()->profile->gender == "女性") checked @endif><label for="2">女性</label>
                  </div>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">郵便番号</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <div class="form-row m-0">
                    <input class="form-control form-control col-3 col-md-3 {{ $errors->has('data.apply.postcode01') ? 'is-invalid' : '' }}" type="text" name="data[apply][postcode01]" maxlength="3" value="@if(old('data.apply.postcode01')){{ old('data.apply.postcode01') }}@elseif(Session::has('front.data.entry.postcode01')){{ Session::get('front.data.entry.postcode01') }}@elseif(array_key_exists(0, $postcode)){{ $postcode[0] }}@endif" required>&nbsp;-&nbsp;<input class="form-control form-control col-4 col-md-4 {{ $errors->has('data.apply.postcode02') ? 'is-invalid' : '' }}" type="text" name="data[apply][postcode02]" maxlength="4" value="@if(old('data.apply.postcode02')){{ old('data.apply.postcode02') }}@elseif(Session::has('front.data.entry.postcode02')){{ Session::get('front.data.entry.postcode02') }}@elseif(array_key_exists(1, $postcode)){{ $postcode[1] }}@endif" onKeyUp="AjaxZip3.zip2addr('data[apply][postcode01]','data[apply][postcode02]','data[apply][prefecture]','data[apply][city]');" required>
                  </div>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">都道府県</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <input class="form-control form-control col-8 {{ $errors->has('data.apply.prefecture') ? 'is-invalid' : '' }}" type="text" name="data[apply][prefecture]" value="@if(old('data.apply.prefecture')){{old('data.apply.prefecture')}}@elseif(Session::has('front.data.entry.prefecture')){{Session::get('front.data.entry.prefecture')}}@else{{Auth::guard('seeker')->user()->profile->prefecture}}@endif" required>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">市区町村</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <input class="form-control form-control form-sm-control  {{ $errors->has('data.apply.city') ? 'is-invalid' : '' }}" type="text" name="data[apply][city]" value="@if(old('data.apply.city')){{old('data.apply.city')}}@elseif(Session::has('front.data.entry.city')){{Session::get('front.data.entry.city')}}@else{{Auth::guard('seeker')->user()->profile->city}}@endif" required>
                  <div class="text-danger">※番地や建物名は不要です</div>
                </td>
              </tr>
            </table>
          </section>
          <section class="apply-job-form">
            <h2>現在の状況・希望</h2>
            <table class="apply-job-form-table">
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">現在の職業</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <select name="data[apply][occupation]">
                    <option value="0">-----</option>
                    @foreach(config('const.OCCUPATION') as $occupation)
                    <option value="{{$occupation}}" @if(old('data.apply.occupation')==$occupation) selected @elseif(!old('data.apply.occupation') && Session::get('front.data.entry.occupation')==$occupation ) selected @elseif(!old('data.apply.occupation') && Auth::guard('seeker')->user()->profile->occupation == $occupation) selected @endif>{{$occupation}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">最終学歴</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <select name="data[apply][final_education]">
                    <option value="0">-----</option>
                    @foreach(config('const.FINAL＿EDUCATION') as $education)
                    <option value="{{$education}}" @if(old('data.apply.final_education')==$education ) selected @elseif(!old('data.apply.final_education') && Session::get('front.data.entry.final_education')==$education ) selected @elseif(!old('data.apply.final_education') && Auth::guard('seeker')->user()->profile->final_education == $education) selected @endif>{{$education}}</option>
                    @endforeach

                  </select>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">勤務開始可能日</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <div class="form-group">
                    <input id="3" type="radio" name="data[apply][work_start_date]" value="いつでも可能" @if(old('data.apply.work_start_date')=='いつでも可能' ) checked @elseif(!old('data.apply.work_start_date') && Session::get('front.data.entry.work_start_date')=='いつでも可能' ) checked @elseif(!old('data.apply.work_start_date') && Auth::guard('seeker')->user()->profile->work_start_date == "いつでも可能") checked @endif><label for="3">いつでも可能</label>
                    <input id="4" type="radio" name="data[apply][work_start_date]" value="面接時に相談" @if(old('data.apply.work_start_date')=='面接時に相談' ) checked @elseif(!old('data.apply.work_start_date') && Session::get('front.data.entry.work_start_date')=='面接時に相談' ) checked @elseif(!old('data.apply.work_start_date') && Auth::guard('seeker')->user()->profile->work_start_date == "面接時に相談") checked @endif><label for="4">面接時に相談</label>
                  </div>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">志望動機・メッセージ</span>
                </th>
                <td>
                  <div class="form-group mb-0">
                    <textarea class="form-control" name="data[apply][job_msg]" rows="5" placeholder="ここで自己PRすると採用につながりやすくなります。&#13例）応募した理由や仕事を通じてやりたいことなど（1000字以内）">@if(old('data.apply.job_msg')){{old('data.apply.job_msg')}}@else{{Session::get('front.data.entry.job_msg')}}@endif</textarea>
                  </div>
                </td>
              </tr>
            </table>
          </section>
          @if($jobitem->job_q1 || $jobitem->job_q2 || $jobitem->job_q3)
          <section class="apply-job-form mb-3">
            <h2>企業からあなたへの質問</h2>
            <table class="apply-job-form-table apply-job-form-table-last">
              @if($jobitem->job_q1)
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">Q1. {{$jobitem->job_q1}}</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <div class="form-group">
                    <textarea class="form-control" name="data[apply][job_q1]" rows="5" required>@if(old('data.apply.job_q1')){{old('data.apply.job_q1')}}@else{{Session::get('front.data.entry.job_q1')}}@endif</textarea>
                  </div>
                </td>
              </tr>
              @endif
              @if($jobitem->job_q2)
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">Q2. {{$jobitem->job_q2}}</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <div class="form-group">
                    <textarea class="form-control" name="data[apply][job_q2]" rows="5" required>@if(old('data.apply.job_q2')){{old('data.apply.job_q2')}}@else{{Session::get('front.data.entry.job_q2')}}@endif</textarea>
                  </div>
                </td>
              </tr>
              @endif
              @if($jobitem->job_q3)
              <tr>

                <th>
                  <span class="apply-job-table-heading-text">Q3. {{$jobitem->job_q3}}</span>
                  <span class="apply-job-badge required">必須</span>
                </th>
                <td>
                  <div class="form-group">
                    <textarea class="form-control" name="data[apply][job_q3]" rows="5" required>@if(old('data.apply.job_q3')){{old('data.apply.job_q3')}}@else{{Session::get('front.data.entry.job_q3')}}@endif</textarea>
                  </div>
                </td>
              </tr>
              @endif
            </table>
          </section>
          @endif
          <div class="form-group text-center">
            <input type="submit" class="btn btn-yellow w-50" value="確認画面へ進む">
          </div>
        </form>

        @else
        <div class="container">
          <p class="text-center h5 mt-5 mb-4">求人応募するにはログインが必要です</p>
          <p class="text-center">会員登録されていない方は<a href="{{ route('seeker.register') }}">こちら</a>から登録できます。</p>
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="card login-card">

                <div class="card-body login-card-body">
                  <form method="POST" action="{{ route('seeker.login') }}" aria-label="{{ __('Login') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI'] ?>">

                    <div class="form-group row">
                      <label for="email" class="col-12 col-md-4 col-form-label text-left text-md-right">{{ __('メールアドレス') }}</label>

                      <div class="col-md-6">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="password" class="col-12 col-md-4 col-form-label text-left text-md-right">{{ __('パスワード') }}</label>

                      <div class="col-md-6">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-6 offset-md-3">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                          <label class="form-check-label" for="remember">
                            {{ __('次回から自動ログインする') }}
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row mb-0">
                      <div class="col-md-6 offset-md-3">
                        <button type="submit" class="btn">
                          {{ __('ログイン') }}
                        </button>

                        <a class="forget-passlink" href="{{ route('seeker.password.request') }}">
                          {{ __('パスワードを忘れた方') }}
                        </a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </section>
</div> <!-- main-wrap-->
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection
