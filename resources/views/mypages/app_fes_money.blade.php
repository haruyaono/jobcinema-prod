@extends('layouts.master')

@section('title', '採用決定報告 | JOB CiNEMA')
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
  採用決定報告
  </li>
</ol>
</div>

<div class="main-wrap">
<section class="main-section">
<div class="inner">
<div class="pad">
    <h2 class="txt-h2 mb-3">採用決定報告</h2>
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
    @if(Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
    @endif

        <div class="seeker-jobapp-item">
            <div class="jobapp-item-header">
                <div class="header-status">
                    {{config("const.JOB_STATUS.{$applyJobItem->s_status}", "未定義")}}
                </div>
                <div class="header-date">
                応募日：{{ Carbon\Carbon::parse($applyJobItem->created_at)->format('Y-m-d')}}
                </div>
                @if($applyJobItem->oiwaikin) 
                <div class="header-money">
                この企業に採用されるとお祝い金<span>{{$applyJobItem->oiwaikin}}円！</span>
                </div>
                @endif
            </div>
            <div class="jobapp-item-middle">
                <div class="jobapp-item-img only-pc">
                    @if($jobitem->job_img)
                    <img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{$jobitem->job_img}}@else{{$jobitem->job_img}}@endif" alt="{{$jobitem->company->cname}}">
                    @else
                    <img src="{{asset('uploads/images/no-image.gif')}}">
                    @endif
                </div>
                <div class="jobapp-item-text">
                    <table>
                        <tr>
                            <th>応募企業</th>
                            <td>{{$jobitem->company->cname}}</td>
                        </tr>
                        <tr>
                            <th>勤務先</th>
                            <td>{{$jobitem->job_office}}</td>
                        </tr>
                        <tr>
                            <th>雇用形態</th>
                            <td>{{$jobitem->status_cat_get->name}}</td>
                        </tr>
                        <tr>
                            <th>職種</th>
                            <td>{{$jobitem->job_type}}</td>
                        </tr>   
                    </table>
                </div>
            </div>
        </div>

        <div class="seeker-oiwai-tabwrap">
            <div class="tab_area">
                <label class="tab_label active" for="tab1">初出社日が決まっている方はこちら</label>
                <label class="tab_label" for="tab2">初出社日が未定の方はこちら</label>
            </div>
            <div class="panel_area">
                <div id="panel1" class="tab_panel active">
                    <p>初出社日が決まっている方はご入力ください。<br>（研修や試用期間も初出社日に含まれます)</p>
                    <div class="form-wrap">
                        <form action="{{route('app.fesmoney.post', [$applyJobItem->id])}}" method="POST">
                        @csrf
                        @if($applyJobItem->oiwaikin) 
                        <input type="hidden" name="oiwaikin" value="{{$jobItem->oiwaikin}}">
                        @endif
                            <div class="form-label">初出社日</div>

                            <div class="form-item">
                                <input name="year" class="{{ $errors->has('year') ? 'is-invalid' : ''}}" type="text" placeholder="西暦" maxlength="4" value="{{old('year')}}" required>
                                <span>年</span>
                                <input name="month" type="text" maxlength="2" value="{{old('month')}}" required>
                                <span>月</span>
                                <input name="date" type="text" maxlength="2" value="{{old('date')}}" required>
                                <span>日</span>
                                <input type="submit" name="adopt_submit1" class="btn btn-yellow" value="報告する">
                            </div>
                        </form>
                    </div>
                </div>
                <div id="panel2" class="tab_panel">
                <p>採用が決定していて、初出社日が分からない場合は状況をご記入ください。</p>
                    <div class="form-wrap">
                        <form action="{{route('app.fesmoney.post', [$applyJobItem->id])}}" method="POST">
                        @csrf
                        @if($applyJobItem->oiwaikin) 
                        <input type="hidden" name="oiwaikin" value="{{$jobItem->oiwaikin}}">
                        @endif
                            <textarea name="app_oiwai_text" placeholder="例）初出社日の連絡待ちです。○月上旬頃出社予定です。" class="" rows="6" required></textarea>
                            <input type="submit" name="adopt_submit2" class="btn btn-yellow" value="報告する">
                        </form>
                    </div>
                </div>
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

@section('js')
  <script src="{{ asset('js/main.js') }}"></script>
@endsection
