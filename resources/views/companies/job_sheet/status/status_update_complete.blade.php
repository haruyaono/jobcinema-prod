@extends('layouts.employer_mypage_master')

@section('title', '求人票の申請取り消し | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.employer.mypage_header')
@endcomponent
@endsection

@section('contents')
<div class="main-wrap">
  <section class="main-section job-create-section">
    <div class="inner">
      <div class="pad">
        <div class="col-md-10 mr-auto ml-auto">
          <div class="card">
            <div class="card-body">
              <div class="my-3">
                <p class="after-text h3">{{ $message }}</p>
              </div>
            </div>
          </div> <!-- card -->
          <div class="form-group text-center">
            @if($flag === 9)
            <a class="btn back-btn ml-3" href="{{ route('enterprise.index.joblist') }}"><i class="fas fa-reply mr-3"></i>求人一覧に戻る</a>
            @else
            <a class="btn back-btn ml-3" href="javascript:void(0);" onClick="window.opener.location.reload(),window.close()"><i class="fas fa-reply mr-3"></i>閉じる</a>
            @endif
          </div>
        </div>
      </div> <!-- pad -->
    </div> <!-- inner -->
  </section>
</div> <!-- main-wrap -->
@endsection

@section('footer')
@component('components.employer.mypage_footer')
@endcomponent
@endsection
