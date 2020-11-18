@extends('layouts.master')

@section('title', 'キープリスト | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.header')
@endcomponent
@endsection

@section('contents')
<!-- パンくず -->
<div id="breadcrumb" class="bread only-pc">
  <ol>
    <li>
      <a href="/">
        <i class="fa fa-home"></i><span>釧路の求人情報TOP</span>
      </a>
    </li>
    <li>
      <a>
        キープリスト
      </a>
    </li>
  </ol>
</div>

<div class="main-wrap">
  <section class="main-section job-entry">
    <div class="inner">
      <div class="pad">
        <h1 class="txt-h2">保存したお仕事(最大20件)</h1>
        @if( Auth::guard('seeker')->check() )
        <div class="job-list">
          @if ($result_count > 0 )
          @foreach ($jobitems as $jobitem)
          <div class="job-item">
            <a href="{{ route('show.front.job_sheet.detail', $jobitem) }}" class="job-item-link">
              <div class="job-item-heading only-pc">
                <!-- カテゴリ -->
                <span class="cat-item org">{{ $jobitem->categories()->wherePivot('ancestor_slug', 'type')->first() !== null ? $jobitem->categories()->wherePivot('ancestor_slug', 'type')->first()->name : '' }}</span>
                <span class="cat-item red">{{ $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first() !== null ? $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name : '' }}</span>
              </div>
              <div class="jobCassette__header">
                <div class="jobCassette__image_wrap only-sp">
                  @if($jobitem->job_img_1)
                  <img src="{{ config('app.s3_url') . config('jobcinema.jobitem_image_dir') . $jobitem->job_img_1 }}" alt="" />
                  @else
                  <img src="{{ asset('img/common/no-image.gif')}}" style="width:100%;" alt="No image">
                  @endif
                </div>
                <div class="jobCassette__title">
                  <p class="jobCassette__jobTypeTxt">{{ $jobitem->job_title }}</p>
                  <h2 class="company_name_item">{{ $jobitem->company->cname }}</h2>
                </div>
              </div>

              <div class="d-flex">
                <div class="jobCassette__image_wrap only-pc">
                  @if($jobitem->job_img_1)
                  <img src="{{ config('app.s3_url') . config('jobcinema.jobitem_image_dir') . $jobitem->job_img_1 }}" style="width:100%;" alt="" />
                  @else
                  <img src="{{ asset('img/common/no-image.gif')}}" style="width:100%;" alt="No image">
                  @endif
                </div>
                <div class="job-right">
                  <table class="job-table">
                    <tr>
                      <th><span class="money"><span>給与</span></span></th>
                      <td>{{ str_limit($jobitem->job_salary, $limit = 40, $end = '...')}}</td>
                    </tr>
                    <tr>
                      <th><span class="place"><span>勤務先</span></span></th>
                      <td>{{ str_limit($jobitem->job_office, $limit = 40, $end = '...')}}</td>
                    </tr>
                    <tr>
                      <th><span class="work"><span>仕事内容</span></span></th>
                      <td>{{ str_limit($jobitem->job_desc, $limit = 80, $end = '...')}}</td>
                    </tr>
                    <tr>
                      <th><span class="time"><span>勤務時間</span></span></th>
                      <td>{{ str_limit($jobitem->job_time, $limit = 40, $end = '...')}}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </a>
          </div>
          @endforeach
          @else
          <p class="no-jobitem-txt">現在「キープリスト」に保存された情報はありません。</p>
          @endif

        </div>
        @else
        <div class="container">
          <p class="text-center h5 mt-5 mb-4">キープリストを使用するにはログインが必要です</p>
          <p class="text-center">会員登録されていない方は<a href="{{ route('seeker.register') }}">こちら</a>から登録できます。</p>
          <div class="row justify-content-center">
            <div class="col-md-10">
              <div class="card login-card">

                <div class="card-body login-card-body">
                  <form method="POST" action="{{ route('seeker.login') }}" aria-label="{{ __('Login') }}">
                    {{ csrf_field() }}

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
      </div><!-- pad -->
    </div> <!-- inner -->
  </section> <!-- newjob-entry -->
</div> <!-- main-wrap-->
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection
