@extends('layouts.master')

@section('title', 'JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.header')
@endcomponent
@endsection

@section('contents')

<?php
$jobjson = json_encode($jobitem);
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
      {{$jobitem->company->cname}}
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
        <h1 class="txt-h1">{{$jobitem->company->cname}}の求人情報</h1>
        <!-- カテゴリ -->
        <span class="cat-item org">{{$jobitem->categories()->wherePivot('ancestor_slug', 'type')->first() !== null ? $jobitem->categories()->wherePivot('ancestor_slug', 'type')->first()->name : ''}}</span>
        <span class="cat-item red">{{$jobitem->categories()->wherePivot('ancestor_slug', 'status')->first() !== null ? $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name : ''}}</span>

        <h2>{{$jobitem->job_title}}</h2>
        <p class="company_name_item">{{$jobitem->company->cname}}</p>
        <div class="text-contents">
          {!! nl2br(e($jobitem->job_intro)) !!}
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
        <!--  求人内容-->
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
                <p>{{ $jobitem->job_office }}</p>
              </div>
            </div>
            <div class="item-row">
              <div class="row-label">雇用形態</div>
              <div class="row-text">
                <p>{{$jobitem->categories()->wherePivot('ancestor_slug', 'status')->first() !== null ? $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name : ''}}</p>
              </div>
            </div>
            <div class="item-row">
              <div class="row-label">職種</div>
              <div class="row-text row-job-occupation">
                <p>{{ $jobitem->job_type}}</p>
              </div>
            </div>
            <div class="item-row">
              <div class="row-label">仕事内容</div>
              <div class="row-text">
                <p>{!! nl2br(e($jobitem->job_desc)) !!}</p>
              </div>
            </div>
            <div class="item-row">
              <div class="row-label">給与</div>
              <div class="row-text row-job-salary">
                <p>{!! nl2br(e($jobitem->job_salary)) !!}</p>
              </div>
            </div>
            @if($jobitem->salary_increase)
            <div class="item-row">
              <div class="row-label">昇給・賞与</div>
              <div class="row-text">
                <p>{!! nl2br(e($jobitem->salary_increase)) !!}</p>
              </div>
            </div>
            @endif
            <div class="item-row">
              <div class="row-label">応募資格</div>
              <div class="row-text">
                <p>{!! nl2br(e($jobitem->job_target)) !!}</p>
              </div>
            </div>
            <div class="item-row">
              <div class="row-label">住所</div>
              <div class="row-text">
                <p>{!! nl2br(e($jobitem->job_office_address)) !!}</p>
              </div>
            </div>
            <div class="item-row">
              <div class="row-label">勤務時間</div>
              <div class="row-text">
                <p>{!! nl2br(e($jobitem->job_time)) !!}</p>
              </div>
            </div>


            <div class="item-row">
              <div class="row-label">待遇・福利厚生</div>
              <div class="row-text">
                <p>{!! nl2br(e($jobitem->job_treatment)) !!}</p>
              </div>
            </div>
            @if($jobitem->remarks)
            <div class="item-row">
              <div class="row-label">その他</div>
              <div class="row-text">
                <p>{!! nl2br(e($jobitem->remarks)) !!}</p>
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
            @if($jobitem->company->cname)
            <div class="item-row">
              <div class="row-label">会社名</div>
              <div class="row-text">
                <p>{{ $jobitem->company->cname }}</p>
              </div>
            </div>
            @endif
            <div class="item-row">
              <div class="row-label">本社所在地</div>
              <div class="row-text">
                @if($jobitem->company->postcode)
                <p>{{ $jobitem->company->postcode }}</p>
                @endif
                @if($jobitem->company->prefecture)
                <p>{{ $jobitem->company->prefecture }}</p>
                @endif
                @if($jobitem->company->address)
                <p>{{ $jobitem->company->address }}</p>
                @endif
              </div>
            </div>
            @if($jobitem->company->ceo)
            <div class="item-row">
              <div class="row-label">代表</div>
              <div class="row-text">
                <p>{{ $jobitem->company->ceo }}</p>
              </div>
            </div>
            @endif
            @if($jobitem->company->foundation)
            <div class="item-row">
              <div class="row-label">設立</div>
              <div class="row-text">
                <p>{{ $jobitem->company->foundation }}</p>
              </div>
            </div>
            @endif
            @if($jobitem->company->capital)
            <div class="item-row">
              <div class="row-label">資本金</div>
              <div class="row-text">
                <p>{{ $jobitem->company->capital }}円</p>
              </div>
            </div>
            @endif
            @if($jobitem->company->employee_number)
            <div class="item-row">
              <div class="row-label">従業員数</div>
              <div class="row-text">
                <p>{{ $jobitem->company->employee_number }}</p>
              </div>
            </div>
            @endif
            @if($jobitem->company->description)
            <div class="item-row">
              <div class="row-label">事業内容</div>
              <div class="row-text">
                <p>{!! nl2br(e( $jobitem->company->description )) !!}</p>
              </div>
            </div>
            @endif
            @if($jobitem->company->website)
            <div class="item-row">
              <div class="row-label">ホームページ</div>
              <div class="row-text">
                <p><a href="{{ $jobitem->company->website }}">{{ $jobitem->company->website }}</a></p>
              </div>
            </div>
            @endif
          </div>
        </div>

        <div class="entrybtn-field">
          @if(Auth::guard()->check())
          <favourite-component :jobid={{$jobitem->id}} :favourited={{$jobitem->checkSaved()?'true':'false'}}></favourite-component>
          <div class="entrybtn-item">
            @if(!$existsApplied)
            <a class="entry-btn apply-btn" href="{{route('apply.step1.get', [$jobitem->id])}}">応募する</a>
            @else
            <a class="entry-btn apply-btn non-link" href="javascript:void(0)">応募済み</a>
            @endif
          </div>
          @else
          @if(!Auth::guard('employer')->check())
          <div class="entrybtn-item">
            <a class="entry-btn apply-btn" href="{{route('apply.step1.get', [$jobitem->id])}}">応募する</a>
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
              <a href="{{route('show.front.job_sheet.detail', $recommendJob)}}">
                <div class="wrap-img">
                  @if(($recommendJob->job_img_1) != null)
                  <img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}@else{{config('app.s3_url_local')}}@endif{{config('fpath.job_sheet_img') . $recommendJob->job_img_1}}" style="width:100%;" alt="" />
                  @else
                  <img src="{{ asset('img/common/no-image.gif')}}" style="width:100%;" alt="No image">
                  @endif
                </div>
                <div class="wrap-text">
                  <p>■勤務先: {{ str_limit($recommendJob->job_office, $limit = 15, $end = '') }}</p>
                  <p>■職種: {{ str_limit($recommendJob->job_type, $limit = 17, $end = '') }}</p>
                  <p>■給与: {{ str_limit($recommendJob->job_salary, $limit = 18, $end = '') }}</p>
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
