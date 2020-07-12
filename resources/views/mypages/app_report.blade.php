@extends('layouts.master')

@section('title', '結果報告 | JOB CiNEMA')
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
    <a href="/mypage/index">
     　マイページ
    </a>
  </li>
  <li>
    <a href="{{route('mypage.jobapp.manage')}}">
     応募管理
    </a>
  </li>
  <li>
  結果報告
  </li>
</ol>
</div>

<div class="main-wrap">
<section class="main-section">
<div class="inner">
<div class="pad">
    <h2 class="txt-h2 mb-3">結果報告</h2>
    <p class="mb-4">こちらの応募の結果を教えてください。</p>
    @if(Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
    @endif
    <div class="seeker-jobapp-result-wrap">
        <div class="seeker-jobapp-item">
            <div class="jobapp-item-header">
                <div class="header-status">
                    {{config("const.JOB_STATUS.{$appliedJobitem->pivot->s_status}", "未定義")}}
                </div>
                <div class="header-date">
                応募日：{{$appliedJobitem->pivot->created_at->format('Y-m-d')}}
                </div>
                @if($appliedJobitem->oiwaikin) 
                <div class="header-money">
                この企業に採用されるとお祝い金<span>{{$appliedJobitem->oiwaikin}}円<span>
                </div>
                @endif
            </div>
            <div class="jobapp-item-middle">
                <div class="jobapp-item-img only-pc">
                    @if($appliedJobitem->job_img)
                    <img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{$appliedJobitem->job_img}}@else{{$appliedJobitem->job_img}}@endif" alt="{{$appliedJobitem->company->cname}}">
                    @else
                    <img src="{{asset('uploads/images/no-image.gif')}}">
                    @endif
                </div>
                <div class="jobapp-item-text">
                    <table>
                        <tr>
                            <th>応募企業</th>
                            <td>{{$appliedJobitem->company->cname}}</td>
                        </tr>
                        <tr>
                            <th>勤務先</th>
                            <td>{{$appliedJobitem->job_office}}</td>
                        </tr>
                        <tr>
                            <th>雇用形態</th>
                            <td>{{$appliedJobitem->categories()->wherePivot('slug', 'status')->first() !== null ? $appliedJobitem->categories()->wherePivot('slug', 'status')->first()->name : ''}}</td>
                        </tr>
                        <tr>
                            <th>職種</th>
                            <td>{{$appliedJobitem->job_type}}</td>
                        </tr>   
                    </table>
                </div>
            </div>
        </div>
        <div class="seeker-jobapp-result-btn">
            <a href="{{route('app.fesmoney.get', [$appliedJobitem->pivot->apply_id])}}" class="btn btn-yellow"><i class="far fa-circle mr-2"></i>採用</a>
            <a class="btn btn-secondary" href="{{route('appjob.unadopt', [$appliedJobitem->pivot->id])}}" onclick="return window.confirm('「不採用」で間違いありませんか？');"><i class="fas fa-times mr-2"></i>不採用</a>
        </div>
    </div>
    

            
</div>
</div>  
</section>
</div>
@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection

