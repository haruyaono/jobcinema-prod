@extends('layouts.master')

@section('title', '応募管理 | JOB CiNEMA')
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
    応募管理
  </li>
</ol>
</div>

<div class="main-wrap">
<section class="main-section">
<div class="inner">
<div class="pad">
    <h2 class="txt-h2 mb-3">応募管理</h2>
    <p class="mb-4">応募データは応募から180日間表示されます。</p>
    @if (Session::has('flash_message_success'))
        <div class="alert alert-success mt-3">
        {!! nl2br(htmlspecialchars(Session::get('flash_message_success'))) !!}
        </div>
    @endif
    @if (Session::has('flash_message_danger'))
        <div class="alert alert-danger mt-3">
        {!! nl2br(htmlspecialchars(Session::get('flash_message_danger'))) !!}
        </div>
    @endif

    <div class="seeker-jobapp-list">
    
        <?php 
            $before6month = date("Y-m-d H:i:s",strtotime("-6 month")); 
        ?>
    @foreach($appliedJobitems as $appliedJobitem)
        @if($appliedJobitem->pivot->created_at > $before6month)
            @if($appliedJobitem->pivot->e_status == 1 || $appliedJobitem->pivot->e_status == 2)
            <div class="status_e_to_seeker">
            採用結果： @if ($appliedJobitem->pivot->e_status == 1)<span class="e-status e-status_1">{{config("const.JOB_STATUS.{$appliedJobitem->pivot->e_status}", "未定義")}}</span>されました！ @elseif($appliedJobitem->pivot->e_status == 2) <span class="e-status e-status_2">{{config("const.JOB_STATUS.{$appliedJobitem->pivot->e_status}", "未定義")}}</span>となりました！@else @endif
            </div>
            @endif
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
                        この企業に採用されるとお祝い金 <span>{{$appliedJobitem->oiwaikin}}円！</span>
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
                                <td>{{$appliedJobitem->status_cat_get->name}}</td>
                            </tr>
                            <tr>
                                <th>職種</th>
                                <td>{{$appliedJobitem->job_type}}</td>
                            </tr>
                            <tr>
                                <th>住所</th>
                                <td>{{str_limit($appliedJobitem->job_office_address, $limit = 16, $end = '...')}}</td>
                            </tr>
                            <tr>
                                <th>電話番号</th>
                                <td>
                                    {{$appliedJobitem->employer->phone1}}-{{$appliedJobitem->employer->phone2}}-{{$appliedJobitem->employer->phone3}}
                                </td>
                            </tr>
                            <tr>
                                <th>採用担当</th>
                                <td>
                                    {{$appliedJobitem->employer->last_name}}
                                </td>
                            </tr>
                        </table> 
                    </div>
                    <div class="jobapp-item-btn">
                        <p><a href="{{route('jobs.show', [$appliedJobitem->id])}}" class="btn txt-blue-link">詳細を見る</a></p>
                        @if($appliedJobitem->pivot->s_status === 0 )
                            <p><a href="{{route('mypage.jobapp.report', [$appliedJobitem->pivot->apply_id])}}" class="btn btn-yellow">結果を報告</a></p>
                            <p><a href="{{route('appjob.decline', [$appliedJobitem->pivot->id])}}" class="btn btn-secondary jobapp-cancel-btn" onclick="return window.confirm('「辞退」するとお祝い金の受け取りやご応募がキャンセルされます。お間違いありませんか？');">選考を辞退</a></p>
                        @elseif($appliedJobitem->pivot->s_status === 1 )
                            @if($appliedJobitem->pivot->oiwaikin)
                                <p><span class="btn btn-outline-yellow">報告済み</span></p>
                                <p>お祝い金について</p>
                                @if($appliedJobitem->pivot->first_attendance === null)
                                <p><a href="{{route('app.fesmoney.get', [$appliedJobitem->pivot->id])}}" class="btn btn-danger">初出勤日が未登録です
                                </a></p>
                                @endif
                            @else
                                <p><span class="btn btn-outline-yellow">報告済み</span></p>
                                @if($appliedJobitem->pivot->first_attendance === null)
                                <p><a href="{{route('app.fesmoney.get', [$appliedJobitem->pivot->id])}}" class="btn btn-danger">初出社日が未登録です</a></p>
                                @endif
                            @endif
                        
                        @elseif($appliedJobitem->pivot->s_status === 2)
                            <p><span class="btn btn-outline-yellow">報告済み</span></p>
                            <a href="{{route('appjob.cancel', [$appliedJobitem->pivot->id])}}" class="adopt-cancel-btn" onclick="return window.confirm('本当に報告を取り消しますか？');">報告を取り消す</a>
                        @endif
                    </div>

                </div>
        </div>
        @endif
    @endforeach
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

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection