<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">ユーザー情報</h1>
<span><a href="javascript:void(0)" style="margin-left:10px;" onclick="history.back(); return false">Back</a></span>
  
    @if(Session::has('message'))
    <div class="alert alert-success" style="margin-top:15px;">{{Session::get('message')}}</div>
    @endif
@stop

<!-- ページの内容を入力 -->
@section('content')
<div class="col-md-12 applicant-detail">
    <div class="applicant-detail-title">お祝い金</div>
    <div class="card">
        @if($job_info->oiwaikin)
        <div class="card-body">
            <table class="table table-bordered applicant-detail-job-table">
                    <tr>
                        <th>金額</th>
                        <td>
                            {{ $job_info->oiwaikin}}円
                        </td>
                        <th>初出社日</th>
                        <td>
                        @if($app_info->oiwaikin)
                            @if($app_info->first_attendance)
                                {{ $app_info->first_attendance}}
                            @elseif(!$app_info->first_attendance && $app_info->no_first_attendance)
                                未定<br>
                                （{{ $app_info->no_first_attendance}}）
                            @endif
                        @else
                            申請されていません
                        @endif
                        </td>
                    </tr>
            </table>
        </div>
        @else 
            お祝い金対象外の求人です
        @endif
    </div>

    <div class="applicant-detail-title">応募先</div>
    <div class="card">
        @if($job_info)
        <div class="card-header">求人番号：{{$job_info->id}}　<a href="{{ route('admin.job.detail', [$job_info->id]) }}" target="_blank">
                                    求人票を確認
                                </a></div>
        <div class="card-body">
            <table class="table table-bordered applicant-detail-job-table">
                    <tr>
                        <th>雇用形態</th>
                        <td>
                            {{ $job_info->status_cat_get->name}}
                        </td>
                        <th>勤務先名</th>
                        <td>
                            {{ $job_info->job_office}}
                        </td>
                    </tr>
                    <tr>
                        <th>職種</th>
                        <td>
                            {{ $job_info->type_cat_get->name}}
                        </td>
                        <th>掲載期間</th>
                        <td>
                            {{ $job_info->pub_start}} 〜　{{ $job_info->pub_end}}
                        </td>
                    </tr>
            </table>
        </div>
        @else 
            応募先の求人情報が存在しません。
        @endif
    </div>

    <div class="applicant-detail-title">応募者情報</div>
    <div class="detail-box">
        <div class="detail-item">
            <div class="item-row">
                <div class="row-label">氏名</div>
                <div class="row-text">
                    <p>{{ $app_info->last_name }} {{ $app_info->first_name}}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">メールアドレス</div>
                <div class="row-text">
                    {{ $user_info->email }}
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">電話番号</div>
                <div class="row-text">
                    <p>{{ $app_info->phone1 }}-{{ $app_info->phone2 }}-{{ $app_info->phone3 }}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">お住まい</div>
                <div class="row-text">
                    <p>
                        〒{{ $app_info->postcode }}<br>
                        {{ $app_info->prefecture }} {{ $app_info->city }}
                    </p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">年齢</div>
                <div class="row-text">
                    <p>{{ $app_info->age }}歳</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">性別</div>
                <div class="row-text">
                <p>{{ $app_info->gender }}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">職業</div>
                <div class="row-text">
                <p>{{ $app_info->occupation }}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">最終学歴</div>
                <div class="row-text">
                <p>{{ $app_info->final_education }}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">勤務開始可能日</div>
                <div class="row-text">
                <p>{{ $app_info->work_start_date }}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">履歴書</div>
                <div class="row-text">
                    @if($user_info->profile->resume)
                        <a href="{{ Storage::url($user_info->profile->resume) }}" target="_blank">履歴書</a>
                    @else 
                        <span>未登録</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($job_info)
    <div class="detail-box">
        <div class="detail-item">
            @if($app_info->job_msg)
            <div class="item-row">
                <div class="row-label">志望動機</div>
                <div class="row-text">
                    <p>{!! nl2br(e($app_info->job_msg)) !!}</p>
                </div>
            </div>
            @endif
            @if($job_info->job_q1)
            <div class="item-row">
                <div class="row-label">1. {{$job_info->job_q1}}</div>
                <div class="row-text">
                {!! nl2br(e($app_info->job_q1)) !!}
                </div>
            </div>
            @endif
            @if($job_info->job_q2)
            <div class="item-row">
                <div class="row-label">2. {{$job_info->job_q2}}</div>
                <div class="row-text">
                {!! nl2br(e($app_info->job_q2)) !!}
                </div>
            </div>
            @endif
            @if($job_info->job_q3)
            <div class="item-row">
                <div class="row-label">3. {{$job_info->job_q3}}</div>
                <div class="row-text">
                {!! nl2br(e($app_info->job_q3)) !!}
                </div>
            </div>
            @endif
            
        </div>
    </div>
    @endif

</div>


@stop

<!-- 読み込ませるCSSを入力 -->
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/admin.css">
@stop

<!-- 読み込ませるJSを入力 -->
@section('js')

@stop