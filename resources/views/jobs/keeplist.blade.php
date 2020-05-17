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
    <h1 class="txt-h2 mb-3">保存したお仕事(最大20件)</h1>
    @if( Auth::check() )
        <div class="job-list">
        @if ($result_count > 0 )
            @foreach ($jobs as $job)
            <div class="job-item">
						<a href="{{ route('jobs.show', [$job->id])}}" class="job-item-link">
              <div class="job-item-heading only-pc">
								<!-- カテゴリ -->
                 <span class="cat-item org">{{ optional($job->type_cat_get)->name}}</span>
                 <span class="cat-item red">{{ optional($job->status_cat_get)->name}}</span>
              </div>
							<div class="title-img-wrap">
              <div class="job-left only-sp">
								@if(($job->job_img) ==! null)
									<img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{$job->job_img}}@else{{$job->job_img}}@endif" alt=""/>
									@endif
								</div>
								<h2 class="txt-h2">
									{{$job->job_title}}
									<p class="company_name_item">{{$job->company->cname}}</p>
								</h2>
                
							</div>

              <div class="d-flex">
                <div class="job-left only-pc">
                  @if(($job->job_img) ==! null)
                  <img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{$job->job_img}}@else{{$job->job_img}}@endif" style="width:100%;" alt=""/>
                  @else
                  <img src="{{ asset('uploads/images/no-image.gif')}}" style="width:100%;" alt="No image">
                  @endif
                </div>
                <div class="job-right">
                  <table class="job-table">
                    <tr>
                      <th><span class="money"><span>給与</span></span></th>
                      <td>{{ str_limit($job->job_hourly_salary, $limit = 40, $end = '...')}}</td>
                    </tr>
                    <tr>
                      <th><span class="place"><span>勤務先</span></span></th>
                      <td>{{ str_limit($job->job_office, $limit = 40, $end = '...')}}</td>
                    </tr>
										<tr>
											<th><span class="work"><span>仕事内容</span></span></th>
											<td>{{ str_limit($job->job_desc, $limit = 80, $end = '...')}}</td>
										</tr>
                    <tr>
                      <th><span class="time"><span>勤務時間</span></span></th>
                      <td>{{ str_limit($job->job_time, $limit = 40, $end = '...')}}</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- <div class="jobitem-footer" @if(!$job->pubend_at) style="display:block; text-align:right;" @endif>
                @if($job->pubend_at)
                <span>{{ $job->pubend_at->format('Y年m月d日') }}に掲載終了</span>
                @endif
                <object>
                  <a href="{{ route('jobs.show', [$job->id, $job->slug])}}" class="btn detail-btn"><span>詳しく見る</span></a>
                </object>
              </div> -->
						</a>
					</div> <!-- newjob-item -->
            <!-- △ ループ終了 △ -->
            @endforeach
        @else
            <p>現在「キープリスト」に保存された情報はありません。</p>
        @endif
                
        </div>
    @else
    <div class="container">
          <p class="text-center h5 mt-5 mb-4">キープリストを使用するにはログインが必要です</p>
          <p class="text-center">会員登録されていない方は<a href="{{route('register')}}">こちら</a>から登録できます。</p>
          <div class="row justify-content-center">
              <div class="col-md-8">
                  <div class="card login-card">

                      <div class="card-body login-card-body">
                          <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                          {{ csrf_field() }}

                              <div class="form-group row">
                                  <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

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
                                  <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

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

                                      <a class="forget-passlink" href="{{ route('password.request') }}">
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
