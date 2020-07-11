@extends('layouts.employer_mypage_master')

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
        <p class="h5 text-center">{{$applyInfo['apply']->last_name}} さんの応募情報</p>
        <div class="col-md-12 px-0">
            <div class="applicant-detail-title">応募された求人</div>
            <div class="card">
                <div class="card-header">求人番号：{{$applyInfo['jobitem']->id}}　<a href="{{ route('job.form.show', [$applyInfo['jobitem']->id]) }}" class="txt-blue-link" target="_blank">
                                            求人票を確認
                                        </a></div>
                <div class="card-body table-responsive">
                    <table class="table text-nowrap table-bordered">
                            <tr>
                                <th>雇用形態</th>
                                <td>
                                    {{ App\Job\Categories\Category::find($applyInfo['jobitem']->categories()->wherePivot('slug', 'status')->first()->id)->name}}
                                </td>
                                <th>勤務先名</th>
                                <td>
                                    {{ $applyInfo['jobitem']->job_office}}
                                </td>
                            </tr>
                            <tr>
                                <th>職種</th>
                                <td>
                                {{ App\Job\Categories\Category::find($applyInfo['jobitem']->categories()->wherePivot('slug', 'type')->first()->id)->name}}
                                </td>
                                <th>掲載期間</th>
                                <td>
                                    {{ $applyInfo['jobitem']->pub_start}} 〜　{{ $applyInfo['jobitem']->pub_end}}
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
                            <p>{{ $applyInfo['apply']->last_name }} {{ $applyInfo['apply']->first_name}}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">メールアドレス</div>
                        <div class="row-text">
                            {{ $applyInfo['applicant']->email }}
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">電話番号</div>
                        <div class="row-text">
                            <p>{{ $applyInfo['apply']->phone1 }}-{{ $applyInfo['apply']->phone2 }}-{{ $applyInfo['apply']->phone3 }}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">お住まい</div>
                        <div class="row-text">
                            <p>
                                〒{{ $applyInfo['apply']->postcode }}<br>
                                {{ $applyInfo['apply']->prefecture }} {{ $applyInfo['apply']->city }}
                            </p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">年齢</div>
                        <div class="row-text">
                            <p>{{ $applyInfo['apply']->age }}歳</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">性別</div>
                        <div class="row-text">
                        <p>{{ $applyInfo['apply']->gender }}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">職業</div>
                        <div class="row-text">
                        <p>{{ $applyInfo['apply']->occupation }}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">最終学歴</div>
                        <div class="row-text">
                        <p>{{ $applyInfo['apply']->final_education }}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">勤務開始可能日</div>
                        <div class="row-text">
                        <p>{{ $applyInfo['apply']->work_start_date }}</p>
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="row-label">履歴書</div>
                        <div class="row-text">
                            @if($applyInfo['profile']->resumePath != '') 
                                <a href="{{ $applyInfo['profile']->resumePath  }}" class="txt-blue-link" target="_blank">履歴書</a>
                            @else 
                                <span>未登録</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-box">
                <div class="detail-item">
                    @if($applyInfo['apply']->job_msg)
                    <div class="item-row">
                        <div class="row-label">志望動機</div>
                        <div class="row-text">
                            <p>{!! nl2br(e($applyInfo['apply']->job_msg)) !!}</p>
                        </div>
                    </div>
                    @endif
                    @if($applyInfo['jobitem']->job_q1)
                    <div class="item-row">
                        <div class="row-label">1. {{$applyInfo['jobitem']->job_q1}}</div>
                        <div class="row-text">
                        {!! nl2br(e($applyInfo['apply']->job_q1)) !!}
                        </div>
                    </div>
                    @endif
                    @if($applyInfo['jobitem']->job_q2)
                    <div class="item-row">
                        <div class="row-label">2. {{$applyInfo['jobitem']->job_q2}}</div>
                        <div class="row-text">
                        {!! nl2br(e($applyInfo['apply']->job_q2)) !!}
                        </div>
                    </div>
                    @endif
                    @if($applyInfo['jobitem']->job_q3)
                    <div class="item-row">
                        <div class="row-label">3. {{$applyInfo['jobitem']->job_q3}}</div>
                        <div class="row-text">
                        {!! nl2br(e($applyInfo['apply']->job_q3)) !!}
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
                @if($applyInfo['jobAppliedInfo']->pivot->e_status === 1 || $applyInfo['jobAppliedInfo']->pivot->e_status === 2 )
                    <p>
                        <a href="{{route('emp.applicant.adopt.cancel', [$applyInfo['jobitem']->id, $applyInfo['apply']->id])}}" class="adopt-cancel-btn" onclick="return window.confirm('本当に採用を取り消しますか？');">
                    採用を取り消す</a>
                    </p>
                @else
                    <p>
                        <a href="{{route('emp.applicant.adopt', [$applyInfo['jobitem']->id, $applyInfo['apply']->id])}}" class="btn btn-yellow" onclick="return window.confirm('「採用」で間違いありませんか？');"><i class="fas fa-times mr-2"></i>採用</a>
                    </p>
                    <p>
                        <a href="{{route('emp.applicant.unadopt', [$applyInfo['jobitem']->id, $applyInfo['apply']->id])}}" class="btn btn-secondary" onclick="return window.confirm('「不採用」で間違いありませんか？');"><i class="fas fa-times mr-2"></i>不採用</a>
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
