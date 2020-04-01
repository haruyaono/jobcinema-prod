@extends('layouts.employer_mypage_master2')

@section('title', '応募者情報| JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.employer.mypage_header')
  @endcomponent
@endsection

@section('contents')
<!-- パンくず -->
<div id="breadcrumb" class="e-mypage-bread only-pc">
<ol>
  <li>
      <a href="/company/mypage"><span class="bread-text-color-blue">企業ページ</span></a>
  </li>
  <li>
   <span class="bread-text-color-red">応募者情報</span>
  </li>
</ol>
</div>
<div class="main-wrap">
<section class="main-section myjob-section myjob-detail-section">
<div class="inner">
<div class="pad">
    <div class="row w-100 m-0 justify-content-center">
        <p class="h5 text-center">{{$applicantUserInfo->pivot->last_name}} さんの応募情報</p>
        <div class="col-md-12 px-0">
            <div class="applicant-detail-title">応募された求人</div>
            <div class="card">
                <div class="card-header">求人番号：{{$job->id}}　<a href="{{ route('job.form.show', [$job->id]) }}" target="_blank">
                                            求人票を確認
                                        </a></div>
                <div class="card-body table-responsive">
                    <table class="table text-nowrap table-bordered">
                            <tr>
                                <th>雇用形態</th>
                                <td>
                                    {{ $job->status_cat_get->name}}
                                </td>
                                <th>勤務先名</th>
                                <td>
                                    {{ $job->job_office}}
                                </td>
                            </tr>
                            <tr>
                                <th>職種</th>
                                <td>
                                    {{ $job->type_cat_get->name}}
                                </td>
                                <th>掲載期間</th>
                                <td>
                                    {{ $job->pub_start}} 〜　{{ $job->pub_end}}
                                </td>
                            </tr>
                    </table>
                </div>
            </div>

            <div class="applicant-detail-title">応募者情報</div>
            <div class="detail-box">
                <div class="detail-item">
                    <div class="item-row">
                        <div class="row-label">氏名</div>
                        <div class="row-text">
                            <p>{{ $applicantUserInfo->pivot->last_name }} {{ $applicantUserInfo->pivot->first_name}}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">メールアドレス</div>
                        <div class="row-text">
                            {{ $applicantUser->email }}
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">電話番号</div>
                        <div class="row-text">
                            <p>{{ $applicantUserInfo->pivot->phone1 }}-{{ $applicantUserInfo->pivot->phone2 }}-{{ $applicantUserInfo->pivot->phone3 }}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">お住まい</div>
                        <div class="row-text">
                            <p>
                                〒{{ $applicantUserInfo->pivot->postcode }}<br>
                                {{ $applicantUserInfo->pivot->prefecture }} {{ $applicantUserInfo->pivot->city }}
                            </p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">年齢</div>
                        <div class="row-text">
                            <p>{{ $applicantUserInfo->pivot->age }}歳</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">性別</div>
                        <div class="row-text">
                        <p>{{ $applicantUserInfo->pivot->gender }}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">職業</div>
                        <div class="row-text">
                        <p>{{ $applicantUserInfo->pivot->occupation }}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">最終学歴</div>
                        <div class="row-text">
                        <p>{{ $applicantUserInfo->pivot->final_education }}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">勤務開始可能日</div>
                        <div class="row-text">
                        <p>{{ $applicantUserInfo->pivot->work_start_date }}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">履歴書</div>
                        <div class="row-text">
                            @if($applicantUser->profile->resume)
                                <a href="{{ Storage::url($applicantUser->profile->resume) }}" target="_blank">履歴書</a>
                            @else 
                                <span>未登録</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-box">
                <div class="detail-item">
                    @if($applicantUserInfo->pivot->job_msg)
                    <div class="item-row">
                        <div class="row-label">志望動機</div>
                        <div class="row-text">
                            <p>{!! nl2br(e($applicantUserInfo->pivot->job_msg)) !!}</p>
                        </div>
                    </div>
                    @endif
                    @if($job->job_q1)
                    <div class="item-row">
                        <div class="row-label">1. {{$job->job_q1}}</div>
                        <div class="row-text">
                        {!! nl2br(e($applicantUserInfo->pivot->job_q1)) !!}
                        </div>
                    </div>
                    @endif
                    @if($job->job_q2)
                    <div class="item-row">
                        <div class="row-label">2. {{$job->job_q2}}</div>
                        <div class="row-text">
                        {!! nl2br(e($applicantUserInfo->pivot->job_q2)) !!}
                        </div>
                    </div>
                    @endif
                    @if($job->job_q3)
                    <div class="item-row">
                        <div class="row-label">3. {{$job->job_q3}}</div>
                        <div class="row-text">
                        {!! nl2br(e($applicantUserInfo->pivot->job_q3)) !!}
                        </div>
                    </div>
                    @endif
                   
                </div>
            </div>

            <div class="emp-adopt-area">
                <p class="h4 mb-3">採用通知</p>
                <p>採用通知すると、応募者に採用・不採用の結果を渡せます。</p>
                <p>応募者に電話もしくはメールで採用結果をお伝えした後に、採用通知してあげましょう。</p>

                <div class="seeker-adopt-btn-wrap">
                @if($applicantUserInfo->pivot->e_status != 1 && $applicantUserInfo->pivot->e_status != 2 )
                <p>
                    <a href="{{route('emp.applicant.adopt', [$job->id, $applicantUser->id])}}" class="btn btn-yellow" onclick="return window.confirm('「採用」で間違いありませんか？');"><i class="fas fa-times mr-2"></i>採用</a>
                </p>
                <p>
                    <a href="{{route('emp.applicant.unadopt', [$job->id, $applicantUser->id])}}" class="btn btn-secondary" onclick="return window.confirm('「不採用」で間違いありませんか？');"><i class="fas fa-times mr-2"></i>不採用</a>
                </p>
                @else
                <p>
                    <a href="{{route('emp.applicant.adopt.cancel', [$job->id, $applicantUser->id])}}" class="adopt-cancel-btn" onclick="return window.confirm('本当に採用を取り消しますか？');">
                採用を取り消す</a>
                </p>
                @endif
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a class="btn back-btn" href="#" onclick="javascript:window.history.back(-1);return false;"><i class="fas fa-reply mr-3"></i>前に戻る</a>
    </div>
</div>  <!-- pad -->
</div>  <!-- inner --> 
</section>
</div> <!-- main-wrap -->
@endsection


@section('footer')
  @component('components.employer.mypage_footer')
  @endcomponent
@endsection
