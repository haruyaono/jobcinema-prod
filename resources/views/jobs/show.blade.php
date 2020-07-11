@extends('layouts.master')

@section('title', 'JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.header')
  @endcomponent
@endsection

@section('contents')

<?php 
  $jobjson = json_encode($job);  
?>

<!-- パンくず -->
<div id="breadcrumb" class="bread only-pc">
<ol>
  <li>
    <a href="/">
      <i class="fa fa-home"></i><span>釧路の求人情報TOP</span>
    </a>
  </li>
  <li>
      @isset ($title) {{$title}} @endisset
  </li>
</ol>
</div>
<!-- ここからメインコンテンツ -->
<div class="main-wrap">
	<!-- 案件個別 -->
  
	<section class="main-section invi-job-entry">
		<div class="inner">

			<div class="pad">
      @if(Session::has('message'))
            <div class="alert alert-success">
                {{ Session::get('message') }}
            </div>
            @endif
				<h1 class="txt-h1">@isset ($title) {{$title}}@endissetの求人情報</h1>
        <!-- カテゴリ -->
         <span class="cat-item org">{{ $category['type']->name }}</span>
         <span class="cat-item red">{{ $category['status']->name }}</span>

        <h2>{{$job->job_title}}</h2>
      	<p class="company_name_item">@isset ($title) {{$title}}@endisset</p>
        <div class="text-contents">
          {!! nl2br(e($job->job_intro)) !!}
        </div>
    <div class="media-wrap">
      <!-- 動画スライダー -->
        <div class="full-wide-slider">
          <v-slick v-bind:jobjson="{{$jobjson}}"></v-slick>
        </div>
        <!-- 画像　横並び -->
        <div class="image3-area">
          <div class="detail-slider">
            <v-slick1 v-bind:jobjson="{{$jobjson}}"></v-slick1>
          </div>
        </div>
    </div>
    <!--  案件内容の詳細-->
      <div class="detail-box">
        <div class="detail-item">
          <div class="item-title">
            <h3>
              募集内容
            </h3>
          </div>
          <div class="item-row">
            <div class="row-label">勤務先</div>
            <div class="row-text row-job-place">
              <p>{{ $job->job_office }}</p>
            </div>
          </div>
          <div class="item-row">
            <div class="row-label">雇用形態</div>
            <div class="row-text">
              <p>{{ $category['status']->name }}</p>
            </div>
          </div>
          <div class="item-row">
            <div class="row-label">職種</div>
            <div class="row-text row-job-occupation">
              <p>{{ $job->job_type}}</p>
            </div>
          </div>
          <div class="item-row">
            <div class="row-label">仕事内容</div>
            <div class="row-text">
              <p>{!! nl2br(e($job->job_desc)) !!}</p>
            </div>
          </div>
          <div class="item-row">
            <div class="row-label">給与</div>
            <div class="row-text row-job-salary">
              <p>{!! nl2br(e($job->job_hourly_salary)) !!}</p>
            </div>
          </div>
          @if($job->salary_increase)
          <div class="item-row">
            <div class="row-label">昇給・賞与</div>
            <div class="row-text">
              <p>{!! nl2br(e($job->salary_increase)) !!}</p>
            </div>
          </div>
          @endif
          <div class="item-row">
            <div class="row-label">応募資格</div>
            <div class="row-text">
              <p>{!! nl2br(e($job->job_target)) !!}</p>
            </div>
          </div>
          <div class="item-row">
            <div class="row-label">住所</div>
            <div class="row-text">
              <p>{!! nl2br(e($job->job_office_address)) !!}</p>
            </div>
          </div>
          <div class="item-row">
            <div class="row-label">勤務時間</div>
            <div class="row-text">
              <p>{!! nl2br(e($job->job_time)) !!}</p>
            </div>
          </div>

          
          <div class="item-row">
            <div class="row-label">待遇・福利厚生</div>
            <div class="row-text">
              <p>{!! nl2br(e($job->job_treatment)) !!}</p>
            </div>
          </div>
          @if($job->remarks)
          <div class="item-row">
            <div class="row-label">その他</div>
            <div class="row-text">
              <p>{!! nl2br(e($job->remarks)) !!}</p>
            </div>
          </div>
          @endif
          <?php
            if($job->pub_start != '最短で掲載') {
              $job_start = $job->pub_start;
            } else {
              $job_start = '';
            }

            if($job->pub_end != '無期限で掲載') {
              $job_end = $job->pub_end;
            } else {
              $job_end = '';
            }
            
          ?>
          @if($job_end != '')
          <div class="item-row">
            <div class="row-label">掲載期間</div>
            <div class="row-text">
              <p> {{ $job_start }}〜{{ $job_end }}</p>
            </div>
          </div>
          @endif
        </div> <!-- detail-item -->
      </div> <!-- detail-box -->

      <div class="detail-box">
        <div class="detail-item">
          <div class="item-title">
            <h3>
              会社情報
            </h3>
          </div>
          @if($job->company->cname)
          <div class="item-row">
            <div class="row-label">会社名</div>
            <div class="row-text">
              <p>{{ $job->company->cname }}</p>
            </div>
          </div>
          @endif
          <div class="item-row">
            <div class="row-label">本社所在地</div>
            <div class="row-text">
              @if($job->company->postcode)
                <p>{{ $job->company->postcode }}</p>
              @endif
              @if($job->company->prefecture)
                <p>{{ $job->company->prefecture }}</p>
              @endif
              @if($job->company->address)
                <p>{{ $job->company->address }}</p>
              @endif
            </div>
          </div>
          @if($job->company->ceo)
          <div class="item-row">
            <div class="row-label">代表</div>
            <div class="row-text">
              <p>{{ $job->company->ceo }}</p> 
            </div>
          </div>
          @endif
          @if($job->company->foundation)
          <div class="item-row">
            <div class="row-label">設立</div>
            <div class="row-text">
              <p>{{ $job->company->foundation }}</p>
            </div>
          </div>
          @endif
          @if($job->company->capital)
          <div class="item-row">
            <div class="row-label">資本金</div>
            <div class="row-text">
              <p>{{ $job->company->capital }}円</p>
            </div>
          </div>
          @endif
          @if($job->company->employee_number)
          <div class="item-row">
            <div class="row-label">従業員数</div>
            <div class="row-text">
              <p>{{ $job->company->employee_number }}</p>
            </div>
          </div>
          @endif
          @if($job->company->description)
          <div class="item-row">
            <div class="row-label">事業内容</div>
            <div class="row-text">
              <p>{!! nl2br(e( $job->company->description )) !!}</p>
            </div>
          </div>
          @endif
          @if($job->company->website)
          <div class="item-row">
            <div class="row-label">ホームページ</div>
            <div class="row-text">
              <p><a href="{{ $job->company->website }}">{{ $job->company->website }}</a></p>
            </div>
          </div>
          @endif
        </div>
      </div>
        
      <div class="entrybtn-field">
        @if(Auth::guard()->check())
          <favourite-component :jobid={{$job->id}} :favourited={{$job->checkSaved()?'true':'false'}}></favourite-component>
          <div class="entrybtn-item">
          @if(!$existsApplied)
              <a class="entry-btn apply-btn" href="{{route('apply.step1.get', [$job->id])}}">応募する</a>
          @else
            <a class="entry-btn apply-btn non-link" href="javascript:void(0)">応募済み</a>
          @endif
          </div>
        @else
          @if(!Auth::guard('employer')->check())
            <div class="entrybtn-item">
              <a class="entry-btn apply-btn" href="{{route('apply.step1.get', [$job->id])}}">応募する</a>
            </div>
          @endif
        @endif
        
      </div> <!-- entrybtn-field -->

      @if($recommendJobList != []) 
      <div id="recommend-joblist" class="block-joblist">
        <div class="box-title">
          <h3>
            <i class="far fa-clock font-yellow mr-2 h4"></i>あなたへのオススメ求人
          </h3>
        </div>
        <ul class="box-wrap cf">
          @foreach($recommendJobList as $recommendJob)
          <li class="wrap-items">
            <a href="{{route('jobs.show', [$recommendJob->id])}}">
              <div class="wrap-img">
              @if(($recommendJob->job_img) != null)
                <img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{$recommendJob->job_img}}@else{{$recommendJob->job_img}}@endif" style="width:100%;" alt=""/>
              @else
                <img src="{{ asset('uploads/images/no-image.gif')}}" style="width:100%;" alt="No image">
              @endif
              </div>
              <div class="wrap-text">
                <p>■勤務先: {{ str_limit($recommendJob->job_office, $limit = 15, $end = '') }}</p>
                <p>■職種: {{ str_limit($recommendJob->job_type, $limit = 17, $end = '') }}</p>
                <p>■給与: {{ str_limit($recommendJob->job_hourly_salary, $limit = 18, $end = '') }}</p>
              </div>
            </a>
          </li>
          @endforeach
        </ul>
      </div>
      @endif
      <recent-component></recent-component>

      <div class="main-section-item top-subsection-item">
					<div class="top-subsection-item-inner">
						<h2>アルバイト/正社員の求人情報JOBCiNEMA
						</h2>
						<div class="top-subsection-item-text">
						釧路に特化した求人情報サイト「JOBCiNEMA」では、アルバイト採用者5,000円/正社員採用者1万円のお祝い金をプレゼントしております！<br>釧路のお仕事情報を地域、職種、時給などさまざまな方法で検索可能です。<br>職場の雰囲気をリアルに伝えるために多数の動画を掲載！
						</div>
					</div>
				</div>

		 </div> <!-- pad -->

		</div> <!-- inner -->
	</section> <!-- job-entry -->

</div> <!-- main-wrap-->
@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection

@section('js')

@endsection

