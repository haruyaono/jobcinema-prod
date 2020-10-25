@extends('layouts.apply_form_master')

@section('title', '応募内容の確認')
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
        @if(isset($existsAppliedJob) )

        @else
        <h1 class="txt-h1">{{ $jobitem->job_office}}への応募内容の確認</h1>
        <section class="apply-job-info">
          <h2>応募先企業</h2>
          <div class="job-apply-item">
            <div class="d-flex">
              <div class="job-left only-pc">
                @if($jobitem->job_img_1)
                <img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}@else{{config('app.s3_url_local')}}@endif{{config('fpath.job_sheet_img') . $jobitem->job_img_1}}" style="width:100%;" alt="" />
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

        <form action="{{route('store.front.entry.step2', $jobitem)}}" method="POST">
          @csrf
          <section class="apply-job-form">
            <h2>応募する情報</h2>
            <table class="apply-job-form-table">
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">お名前（カナ）</span>
                </th>
                <td>
                  {{Session::get('front.data.entry.last_name')}}&nbsp;{{Session::get('front.data.entry.first_name')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">連絡先電話番号</span>
                </th>
                <td>
                  {{Session::get('front.data.entry.phone1')}}&nbsp;-&nbsp;{{Session::get('front.data.entry.phone2')}}&nbsp;-&nbsp;{{Session::get('front.data.entry.phone3')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">年齢</span>
                </th>
                <td>
                  {{Session::get('front.data.entry.age')}}<span>歳</span>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">性別</span>
                </th>
                <td>
                  {{Session::get('front.data.entry.gender')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">郵便番号</span>
                </th>
                <td>
                  {{Session::get('front.data.entry.zip31')}}&nbsp;-&nbsp;{{Session::get('front.data.entry.zip32')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">都道府県</span>
                </th>
                <td>
                  {{Session::get('front.data.entry.pref31')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">市区町村</span>
                </th>
                <td>
                  {{Session::get('front.data.entry.addr31')}}
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
                </th>
                <td>
                  {{Session::get('front.data.entry.occupation')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">最終学歴</span>
                </th>
                <td>
                  {{Session::get('front.data.entry.final_education')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">勤務開始可能日</span>
                </th>
                <td>
                  {{Session::get('front.data.entry.work_start_date')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">志望動機・メッセージ</span>
                </th>
                <td>
                  @if(Session::has('front.data.entry.job_msg'))
                  {!! nl2br(e(Session::get('front.data.entry.job_msg'))) !!}
                  @endif
                </td>
              </tr>
            </table>
          </section>
          @if($jobitem->job_q1 || $jobitem->job_q2 || $jobitem->job_q3)
          <section class="apply-job-form">
            <h2>企業からあなたへの質問</h2>
            <table class="apply-job-form-table apply-job-form-table-last">
              @if($jobitem->job_q1)
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">Q1. {{$jobitem->job_q1}}</span>
                </th>
                <td>
                  <div class="form-group">
                    {!! nl2br(e(Session::get('front.data.entry.job_q1'))) !!}
                  </div>
                </td>
              </tr>
              @endif
              @if($jobitem->job_q2)
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">Q2. {{$jobitem->job_q2}}</span>
                </th>
                <td>
                  <div class="form-group">
                    {!! nl2br(e(Session::get('front.data.entry.job_q2'))) !!}
                  </div>
                </td>
              </tr>
              @endif
              @if($jobitem->job_q3)
              <tr>

                <th>
                  <span class="apply-job-table-heading-text">Q3. {{$jobitem->job_q3}}</span>
                </th>
                <td>
                  <div class="form-group">
                    <p>{!! nl2br(e(Session::get('front.data.entry.job_q3'))) !!}</p>
                  </div>
                </td>
              </tr>
              @endif
            </table>
          </section>
          @endif
          <div class="form-group text-center">
            <input type="submit" class="btn btn-yellow w-50" value="応募する">
            <a class="btn btn-outline-secondary" href="#" onclick="javascript:window.history.back(-1);return false;">修正する</a>
          </div>
        </form>
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
