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
        <h1 class="txt-h1">{{ $job->job_office}}への応募内容の確認</h1>
        <section class="apply-job-info">
          <h2>応募先企業</h2>
          <div class="job-apply-item">
                <div class="d-flex">
                  <div class="job-left only-pc">
                    @if($job->job_img)
                    <img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{$job->job_img}}@else{{$job->job_img}}@endif" style="width:100%;" alt=""/>
                    @else
                    <img src="{{ asset('uploads/images/no-image.gif')}}" style="width:100%;" alt="No image">
                    @endif 
                  </div>
                  <div class="job-right">
                    <table class="job-apply-table">
                    <tr>
                        <th>応募先企業</th>
                        <td>{{ $job->company->cname}}</td>
                      </tr>
                      <tr>
                        <th>勤務先</th>
                        <td>{{ str_limit($job->job_office, $limit = 40, $end = '...')}}</td>
                      </tr>
                      <tr>
                        <th>雇用形態</th>
                        <td>{{ $job->status_cat_get->name}}</td>
                      </tr>
                      <tr>
                        <th>職種</th>
                        <td>{{ str_limit($job->job_type, $limit = 40, $end = '...')}}</td>
                      </tr>
                    </table>
                  </div>
                </div>
            </div> <!-- newjob-item -->
        </section>

        <form action="{{route('apply.step2.post', [$job->id])}}"  method="POST" class="file-apload-form">
        @csrf
          <section class="apply-job-form">
            <h2>応募する情報</h2>
            <table class="apply-job-form-table">
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">お名前（カナ）</span>
              </th>
                <td>
                    {{Session::get('jobapp_data.last_name')}}&nbsp;{{Session::get('jobapp_data.first_name')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">連絡先電話番号</span>
                </th>
                <td>
                  {{Session::get('jobapp_data.phone1')}}&nbsp;-&nbsp;{{Session::get('jobapp_data.phone2')}}&nbsp;-&nbsp;{{Session::get('jobapp_data.phone3')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">年齢</span>
              </th>
                <td>
                {{Session::get('jobapp_data.age')}}<span>歳</span>
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">性別</span>
              </th>
                <td>
                {{Session::get('jobapp_data.gender')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">郵便番号</span>
                </th>
                <td>
                {{Session::get('jobapp_data.zip31')}}&nbsp;-&nbsp;{{Session::get('jobapp_data.zip32')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">都道府県</span>
                </th>
                <td>
                {{Session::get('jobapp_data.pref31')}}
                </td>
              </tr>
              <tr>
                <th>
                  <span class="apply-job-table-heading-text">市区町村</span>
                </th>
                <td>
                {{Session::get('jobapp_data.addr31')}}
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
              {{Session::get('jobapp_data.occupation')}}
              </td>
            </tr>
            <tr>
              <th>
                <span class="apply-job-table-heading-text">最終学歴</span>
              </th>
              <td>
              {{Session::get('jobapp_data.final_education')}}
              </td>
            </tr>
            <tr>
              <th>
                <span class="apply-job-table-heading-text">勤務開始可能日</span>
            </th>
              <td>
              {{Session::get('jobapp_data.work_start_date')}}
              </td>
            </tr>
            <tr>
              <th>
                <span class="apply-job-table-heading-text">志望動機・メッセージ</span>
            </th>
              <td>
              @if(Session::has('jobapp_data.job_msg'))
              {!! nl2br(e(Session::get('jobapp_data.job_msg'))) !!}
              @endif
              </td>
            </tr>
          </table>
        </section>
        @if($job->job_q1 || $job->job_q2 || $job->job_q3)
        <section class="apply-job-form">
          <h2>企業からあなたへの質問</h2>
          <table class="apply-job-form-table apply-job-form-table-last">
            @if($job->job_q1)
            <tr>
              <th>
                <span class="apply-job-table-heading-text">Q1. {{$job->job_q1}}</span>
            </th>
              <td>
              <div class="form-group">
              {!! nl2br(e(Session::get('jobapp_data.job_q1'))) !!}
              </div>
              </td>
            </tr>
            @endif
            @if($job->job_q2)
            <tr>
              <th>
                <span class="apply-job-table-heading-text">Q2. {{$job->job_q2}}</span>
            </th>
              <td>
              <div class="form-group">
              {!! nl2br(e(Session::get('jobapp_data.job_q2'))) !!}
              </div>
              </td>
            </tr>
            @endif
            @if($job->job_q3)
            <tr>
              
              <th>
                <span class="apply-job-table-heading-text">Q3. {{$job->job_q3}}</span>
            </th>
              <td>
              <div class="form-group">
                <p>{!! nl2br(e(Session::get('jobapp_data.job_q3'))) !!}</p>
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
      </div>
    </div>
  </section>
</div> <!-- main-wrap-->
@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection
