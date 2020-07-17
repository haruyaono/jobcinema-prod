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
    <div class="card-header h5">お祝い金</div>
    <div class="card">
        @if($applyJobItem->pivot->oiwaikin)
        <div class="card-body">
            <table class="table table-bordered applicant-detail-job-table">
                    <tr>
                        <th>金額</th>
                        <td>
                            {{ $applyJobItem->pivot->oiwaikin}}円
                        </td>
                        <th>初出社日</th>
                        <td>
                        @if($applyJobItem->pivot->oiwaikin)
                            @if($applyJobItem->pivot->first_attendance)
                                {{ $applyJobItem->pivot->first_attendance}}
                            @elseif(!$applyJobItem->pivot->first_attendance && $applyJobItem->pivot->no_first_attendance)
                                未定<br>
                                （{{ $applyJobItem->pivot->no_first_attendance}}）
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

    <div class="card-header h5">応募先</div>
    <div class="card">
        @if($applyJobItem)
        <div class="mb-2 h4">求人番号：{{$applyJobItem->id}}　<a href="{{ route('admin.job.detail', [$applyJobItem->id]) }}" target="_blank">
                                    求人票を確認
                                </a></div>
        <div class="card-body">
            <table class="table table-bordered applicant-detail-job-table">
                    <tr>
                        <th>雇用形態</th>
                        <td>
                            {{$applyJobItem->categories()->wherePivot('slug', 'status')->first() !== null ? $applyJobItem->categories()->wherePivot('slug', 'status')->first()->name : ''}}
                        </td>
                        <th>勤務先名</th>
                        <td>
                            {{ $applyJobItem->job_office}}
                        </td>
                    </tr>
                    <tr>
                        <th>職種</th>
                        <td>
                            {{$applyJobItem->categories()->wherePivot('slug', 'status')->first() !== null ? $applyJobItem->categories()->wherePivot('slug', 'status')->first()->name : ''}}
                        </td>
                        <th>掲載期間</th>
                        <td>
                            {{ $applyJobItem->pub_start}} 〜　{{ $applyJobItem->pub_end}}
                        </td>
                    </tr>
            </table>
        </div>
        @else 
            応募先の求人情報が存在しません。
        @endif
    </div>

    <div class="card-header h5">応募者情報</div>
    <div class="detail-box">
        <div class="detail-item">
            <div class="item-row">
                <div class="row-label">氏名</div>
                <div class="row-text">
                    <p>{{ $apply->last_name }} {{ $apply->first_name}}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">メールアドレス</div>
                <div class="row-text">
                    {{ $apply->user->email }}
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">電話番号</div>
                <div class="row-text">
                    <p>{{ $apply->phone1 }}-{{ $apply->phone2 }}-{{ $apply->phone3 }}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">お住まい</div>
                <div class="row-text">
                    <p>
                        〒{{ $apply->postcode }}<br>
                        {{ $apply->prefecture }} {{ $apply->city }}
                    </p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">年齢</div>
                <div class="row-text">
                    <p>{{ $apply->age }}歳</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">性別</div>
                <div class="row-text">
                <p>{{ $apply->gender }}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">職業</div>
                <div class="row-text">
                <p>{{ $apply->occupation }}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">最終学歴</div>
                <div class="row-text">
                <p>{{ $apply->final_education }}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">勤務開始可能日</div>
                <div class="row-text">
                <p>{{ $apply->work_start_date }}</p>
                </div>
            </div>
            <div class="item-row">
                <div class="row-label">履歴書</div>
                <div class="row-text">
                    @if($profile->resumePath != '')
                        <a href="{{ $profile->resumePath }}" target="_blank">履歴書</a>
                    @else 
                        <span>未登録</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($apply->job_msg || $apply->job_q1 || $apply->job_q2 || $apply->job_q3)
    <div class="detail-box">
        <div class="detail-item">
            @if($apply->job_msg)
            <div class="item-row">
                <div class="row-label">志望動機</div>
                <div class="row-text">
                    <p>{!! nl2br(e($apply->job_msg)) !!}</p>
                </div>
            </div>
            @endif
            @if($apply->job_q1)
            <div class="item-row">
                <div class="row-label">1. {{$apply->job_q1}}</div>
                <div class="row-text">
                {!! nl2br(e($apply->job_q1)) !!}
                </div>
            </div>
            @endif
            @if($apply->job_q2)
            <div class="item-row">
                <div class="row-label">2. {{$apply->job_q2}}</div>
                <div class="row-text">
                {!! nl2br(e($apply->job_q2)) !!}
                </div>
            </div>
            @endif
            @if($apply->job_q3)
            <div class="item-row">
                <div class="row-label">3. {{$apply->job_q3}}</div>
                <div class="row-text">
                {!! nl2br(e($apply->job_q3)) !!}
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