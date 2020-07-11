@extends('layouts.employer_mypage_master')

@section('title', '求人票一覧 | JOB CiNEMA')
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
   <span class="bread-text-color-red">求人票一覧</span>
  </li>
</ol>
</div>
<div class="main-wrap">
<section class="main-section myjob-section">
<div class="inner">
<div class="pad">
    <div class="row w-100 m-0  justify-content-center">
        <div class="col-md-10 px-0">
        @if(Session::has('message_alert'))
            <div class="alert alert-danger">
                {{ Session::get('message_alert') }}
            </div>
        @endif
        @if(Session::has('message_success'))
            <div class="alert alert-success"> 
                {{ Session::get('message_success') }}
            </div>
        @endif
        @if($jobs->count() > 0) 
            @foreach($jobs as $job) 
            @if($job->status != 6)
                <div class="card">
                    <div class="card-header">
                        求人番号：{{$job->id}}@if($job->status != 5)<a class="ml-3 txt-blue-link" href="{{ route('myjob.app.delete', [$job]) }}" onclick="return window.confirm('「削除申請」が許可された場合、運営が削除いたします');">削除申請</a>@endif
                    </div>
                    <div class="card-body">
                        <?php
                            $today = date("Y-m-d");
                            if($job->pub_end != '無期限で掲載'){
                                $target_end_day = $job->pub_end;
                            } else {
                                $target_end_day = '';
                            }
                            if($job->pub_start != '最短で掲載'){
                                $target_start_day = $job->pub_start;
                            } else {
                                $target_start_day = '';
                            }
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <th>雇用形態</th>
                                <td>
                                    @foreach($job->categories as $category)
                                        @if($category->parent->name == '雇用形態')
                                            {{$category->name}}
                                        @endif
                                    @endforeach
                                </td>
                                <th>勤務先名</th>
                                <td>
                                    {{ $job->job_office}}
                                </td>
                                <td rowspan="2" class="td-only-pc">
                                    @if($job->status == 0)
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.0')}}</div>
                                    @elseif ($job->status == 1) 
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.1')}}</div>
                                    @elseif ($job->status == 2) 
                                        @if($target_end_day && strtotime($today) > strtotime($target_end_day))
                                        <div class="status-text">掲載終了</div>
                                        @elseif($target_start_day && strtotime($today) < strtotime($target_start_day))
                                        <div class="status-text">掲載待ち</div>
                                        @else
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.2')}}</div>
                                        @endif
                                    @elseif ($job->status == 3) 
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.3')}}</div>
                                    @elseif ($job->status == 4) 
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.4')}}</div>
                                    @elseif ($job->status == 5) 
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.5')}}</div>
                                    @endif
                                    
                                    <a class="btn myjob-show-btn" href="{{ route('job.form.show', [$job]) }}" target="_blank">
                                        求人票を確認する
                                    </a><br>
                                    @if($job->status == 0)
                                        <a class="btn myjob-edit-btn" href="{{ route('job.edit', [$job]) }}" target="_blank">
                                            編集・申請する
                                        </a>
                                    @elseif ($job->status == 1) 
                                        <a class="btn myjob-edit-btn" href="{{ route('myjob.app.cancel.get', [$job]) }}" target="_blank">
                                            申請を取り消す
                                        </a>
                                    @elseif ($job->status == 2) 
                                        <a class="btn" href="{{ route('myjob.app.stop', [$job]) }}">
                                            公開を停止する
                                        </a>
                                    @elseif ($job->status == 3) 
                                        <a class="btn myjob-edit-btn" href="{{ route('job.edit', [$job]) }}" target="_blank">
                                            編集・申請する
                                        </a>
                                    @elseif ($job->status == 4) 
                                    <a class="btn myjob-edit-btn" href="{{ route('job.edit', [$job]) }}" target="_blank">
                                        編集・申請する
                                    </a>
                                    @elseif ($job->status == 5) 
                                    <a class="btn" href="{{ route('myjob.app.delete.cancel', [$job]) }}" onclick="return window.confirm('「削除申請」を取り消しますか？');">
                                        削除申請を取り消す
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>職種</th>
                                <td>
                                    @foreach($job->categories as $category)
                                        @if($category->parent->name == '職種')
                                            {{$category->name}}
                                        @endif
                                    @endforeach
                                </td>
                                <th>掲載期間</th>
                                <td>
                                    {{ $job->pub_start}} 〜　{{ $job->pub_end}}
                                </td>
                            </tr>
                            <tr class="tr-only-sp">
                                <td colspan="4">
                                    <div class="myjob-table-bottom clearfix">
                                    @if($job->status == 0)
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.0')}}</div>
                                    @elseif ($job->status == 1) 
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.1')}}</div>
                                    @elseif ($job->status == 2) 
                                        @if($target_end_day && strtotime($today) > strtotime($target_end_day))
                                        <div class="status-text">掲載終了</div>
                                        @elseif($target_start_day && strtotime($today) < strtotime($target_start_day))
                                        <div class="status-text">掲載待ち</div>
                                        @else
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.2')}}</div>
                                        @endif
                                    @elseif ($job->status == 3) 
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.3')}}</div>
                                    @elseif ($job->status == 4) 
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.4')}}</div>
                                    @elseif ($job->status == 5) 
                                        <div class="status-text">{{config('const.EMP_JOB_STATUS.5')}}</div>
                                    @endif
                                
                                <a class="btn myjob-show-btn" href="{{ route('job.form.show', [$job]) }}" target="_blank">
                                        求人票を確認
                                    </a>
                                @if($job->status == 0)
                                    <a class="btn myjob-edit-btn" href="{{ route('job.edit', [$job]) }}" target="_blank">
                                        編集・申請
                                    </a>
                                @elseif ($job->status == 1) 
                                    <a class="btn myjob-edit-btn" href="{{ route('myjob.app.cancel.get', [$job]) }}" target="_blank">
                                        申請を取消
                                    </a>
                                @elseif ($job->status == 2) 
                                    <a class="btn" href="{{ route('myjob.app.stop', [$job]) }}">
                                        公開を停止
                                    </a>
                                @elseif ($job->status == 3) 
                                    <a class="btn myjob-edit-btn" href="{{ route('job.edit', [$job]) }}" target="_blank">
                                        編集・申請
                                    </a>
                                @elseif ($job->status == 4) 
                                <a class="btn myjob-edit-btn" href="{{ route('job.edit', [$job]) }}" target="_blank">
                                    編集・申請
                                </a>
                                @elseif ($job->status == 5) 
                                <a class="btn" href="{{ route('myjob.app.delete.cancel', [$job]) }}" onclick="return window.confirm('「削除申請」を取り消しますか？');">
                                    削除申請を取消
                                </a>
                                @endif
                                    </div>  
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
                @endforeach
            @else
            <p class="text-center mt-3">作成された求人票はありません。</p>
            @endif
        </div>
    </div>
    <div class="paginate text-center">
      {{ $jobs->appends(Illuminate\Support\Facades\Input::except('page'))->links()}}
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
