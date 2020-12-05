@extends('layouts.master')

@section('title', '最近見た求人 | JOB CiNEMA')
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
        最近見た求人
      </a>
    </li>
  </ol>
</div>

<div class="main-wrap">
  <section class="main-section job-entry">
    <div class="inner">
      <div class="pad">
        <h1 class="txt-h2">最近見た求人</h1>
        <div class="job-list">
          @if ($jobitems !== [])
          @foreach ($jobitems as $jobitem)
          <div class="job-item">

            <a href="{{ route('show.front.job_sheet.detail', $jobitem) }}" class="job-item-link">
              <div class="job-item-heading">
                <!-- カテゴリ -->
                @if($jobitem->isNew() ) <span class="cat-item job-lst-ico job-lst-ico-for-list">NEW</span>@endif
                <span class="cat-item org ib-only-pc">{{ $jobitem->categories()->wherePivot('ancestor_slug', 'type')->first() !== null ? $jobitem->categories()->wherePivot('ancestor_slug', 'type')->first()->name : '' }}</span>
                <span class="cat-item red ib-only-pc">{{ $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first() !== null ? $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name : '' }}</span>
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
                  <p class="jobCassette__jobTypeTxt"> {{ $jobitem->job_title }}</p>
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
          <p class="no-jobitem-txt">閲覧した求人は現在ありません。</p>
          @endif

        </div>
      </div><!-- pad -->
      <div class="paginate text-center">
        {{ $jobitems !== [] ? $jobitems->links() : ''}}
      </div>
    </div> <!-- inner -->
  </section> <!-- newjob-entry -->
</div> <!-- main-wrap-->
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection
