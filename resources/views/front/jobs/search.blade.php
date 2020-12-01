<?php
$jobUrlString = '';
$jobCreateUrl = '';
$getJobUrlPrmList = [];

$getJobUrlPrmList = $_GET;

if ($getJobUrlPrmList !== []) {
  foreach ($getJobUrlPrmList as $key => $value) {
    if ($value === '' || $key === 'page' || $key === 'ks') {
      unset($getJobUrlPrmList[$key]);
      continue;
    }
    $jobUrlString .= '&' . $key . '=' . $value;
  }
  $jobCreateUrl = url('/job_sheet/search/all?') . $jobUrlString;
} else {
  $jobCreateUrl = url('/job_sheet/search/all?');
}
?>
@extends('layouts.master')

@section('title', '釧路の求人情報 | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.header')
@endcomponent
@endsection

@section('contents')
<div id="breadcrumb" class="bread only-pc">
  <ol>
    <li>
      <a href="/">
        <i class="fa fa-home"></i><span>釧路の求人情報TOP</span>
      </a>
    </li>
    <li>
      <a>
        釧路の求人情報
      </a>
    </li>
  </ol>
</div>
<div class="main-wrap">

  <search-component :count="{{ $jobitems->count() }}" :categorylist="{{ $categories }}"></search-component>

  <section class="main-section job-entry">
    <div class="inner">
      <div class="pad cf">
        <h1 class="txt-h1">
          求人検索結果
        </h1>
        <div class="d-flex mb-3 p-works-count-box">
          @if($jobitems->count() > 0)
          <p class="search-count"><span>{{ $jobitems->firstItem() }}件 〜 {{ $jobitems->lastItem() }}件を表示</span></p>
          @endif
        </div>
        <ul class="p-works-sort-conditions">
          <span>並び替え：</span>

          <li><a href="{{$jobCreateUrl}}">新着順</a></li>
          <li><a href="{{$jobCreateUrl . '&ks[f]=1'}}">時給</a></li>
          <li><a href="{{$jobCreateUrl . '&ks[f]=2'}}">日給</a></li>
          <li><a href="{{$jobCreateUrl . '&ks[f]=3'}}">月給</a></li>
          <li><a href="{{$jobCreateUrl . '&ks[f]=4'}}">勤務日数が少ない</a></li>
          <li><a href="{{$jobCreateUrl . '&ks[f]=5'}}">お祝い金額</a></li>
        </ul>
        <select name="job-sort-sp" id="job-sort-sp" data-url="{{$jobCreateUrl}}">
          <option value="0" @if($jobCreateUrl=='' ) selected @endif>新着順</option>
          <option value="1" @if($jobCreateUrl=='' ) selected @endif>時給</option>
          <option value="2" @if($jobCreateUrl=='' ) selected @endif>日給</option>
          <option value="3" @if($jobCreateUrl=='' ) selected @endif>月給</option>
          <option value="4" @if($jobCreateUrl=='' ) selected @endif>勤務日数が少ない</option>
          <option value="5">お祝い金額</option>
        </select>

        <div class="job-list">
          @if ($jobitems->count() > 0 )
          @foreach ($jobitems as $jobitem)
          <div class="job-item">
            <a href="{{ route('show.front.job_sheet.detail', [$jobitem]) }}" class="job-item-link">
              <div class="job-item-heading">
                @if($jobitem->isNew() ) <span class="job-lst-ico job-lst-ico-for-list">NEW</span>@endif
                <span class="cat-item org ib-only-pc">{{ $jobitem->categories()->wherePivot('ancestor_slug', 'type')->first() !== null ? $jobitem->categories()->wherePivot('ancestor_slug', 'type')->first()->name : '' }}</span>
                <span class="cat-item red ib-only-pc">{{ $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first() !== null ? $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name : '' }}</span>
              </div>
              <div class="jobCassette__header">
                <div class="jobCassette__image_wrap only-sp">
                  @if($jobitem->job_img_1)
                  <img src="{{ config('app.s3_url') . config('jobcinema.jobitem_image_dir') . $jobitem->job_img_1 }}" alt="求人の写真" />
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
                  <img src="{{ config('app.s3_url') . config('jobcinema.jobitem_image_dir') . $jobitem->job_img_1 }}" style="width:100%;" alt="求人の写真" />
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
          <p>条件にマッチする求人がありません。</p>
          @endif
        </div>
        <div class="paginate text-center">
          {{ $jobitems->links()}}
        </div>

        <search-history-component></search-history-component>

      </div> <!-- pad -->
    </div> <!-- inner -->
  </section> <!-- newjob-entry -->
</div> <!-- main-wrap-->
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection

@section('js')
<script>
  $(function() {

    function getParam(name, url) {
      if (!url) url = window.location.href;
      name = name.replace(/[\[\]]/g, "\\$&");
      var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    var jobsortItem = $('.p-works-sort-conditions li');
    var sortByKeyValue = getParam('ks[f]');


    if (sortByKeyValue != null) {

      jobsortItem.each(function(index, element) {
        if (sortByKeyValue == index) {
          $(element).addClass('on');
          $(element).children().replaceWith(function() {
            $(this).replaceWith("<span>" + $(this).text() + "</span>")
          });
        }
      });
    } else {
      $(jobsortItem[0]).addClass('on');
      $(jobsortItem[0]).children().replaceWith(function() {
        $(this).replaceWith("<span>" + $(this).text() + "</span>")
      });
    }

    if ($('#job-sort-sp').length) {
      $('#job-sort-sp').change(function() {
        var ks = $(this).val();
        if (ks == 0) {
          window.location.href = $('#job-sort-sp').data('url');
        } else {
          window.location.href = $('#job-sort-sp').data('url') + '&ks[f]=' + ks;
        }

      });

      if (sortByKeyValue != null) {
        $('#job-sort-sp option[value=\'' + sortByKeyValue + '\']').prop('selected', true);
      }
    }

  });
</script>

@endsection
