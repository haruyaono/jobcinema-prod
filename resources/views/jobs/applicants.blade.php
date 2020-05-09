@extends('layouts.employer_mypage_master')

@section('title', '応募者一覧| JOB CiNEMA')
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
   <span class="bread-text-color-red">応募者一覧</span>
  </li>
</ol>
</div>
<div class="main-wrap">
<section class="main-section emp-applicants-section">
<div class="inner">
<div class="pad">
    <div class="d-flex justify-content-center">
        <div class="col-md-12 px-0">
        <p>応募者データは応募日から30日間表示されます。</p>
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

        @if($applicants->count() > 0)
            @foreach($applicants as $applicant)
                <div class="card mt-3">
                    <div class="card-header">
                        求人番号：{{$applicant->id}} <a href="{{ route('jobs.show', [$applicant->id])}}">詳細</a>      
                    </div>
                    
                    <div class="card-body table-responsive">
                        <table class="table text-nowrap applicants-table">
                            <thead class="thead-lignt">
                                <tr>
                                    <th>名前</th>
                                    <th>メールアドレス</th>
                                    <th class="td-only-pc">性別</th>
                                    <th class="td-only-pc">電話番号</th>
                                    <th>採用ステータス</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($applicant->users as $user)
                            <?php 
                                $before1month = date("Y-m-d H:i:s",strtotime("-1 month")); 
                            ?>
                            @if($user->pivot->created_at > $before1month)
                               
                                <tr>
                                    <td>{{ $user->pivot->last_name }}&nbsp{{ $user->pivot->first_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="td-only-pc">{{ $user->pivot->gender }}</td>
                                    <td class="td-only-pc">{{ $user->pivot->phone1 }}-{{ $user->pivot->phone2 }}-{{ $user->pivot->phone3 }}</td>
                                    <td class="e-status-text">
                                    <span class="@if($user->pivot->e_status == 1) font-yellow @elseif($user->pivot->e_status == 2) font-blue @else @endif">
                                        {{config("const.JOB_STATUS.{$user->pivot->e_status}", "未定義")}}
                                    </span>
                                    </td>
                                    <td>
                                        <a href="{{route('applicants.detail', [$applicant->id, $user->id])}}">詳細</a>
                                    </td>
                                </tr>
                            @endif
                               
                            @endforeach
                            </tbody>
                        </table>
                    
                    </div>
                </div>
            @endforeach
        @else
        <p class="text-center mt-3">現在、応募者はいません。</p>
        @endif
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
