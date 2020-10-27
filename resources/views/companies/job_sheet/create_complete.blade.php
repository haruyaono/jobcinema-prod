@extends('layouts.employer_mypage_master')

@section('title', '求人票 | JOB CiNEMA')
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
              @if($updated->status !== 2)
              <div class="my-3">
                <p class="after-text h3 mb-4">求人票の新規登録を受け付けました！</p>
              </div>
              <p>ご登録いただいた情報を確認し、承認作業を行います。<br>
                承認後に求人情報が掲載されますので、しばらくお待ちください。<br>
                ※営業時間内の作業のため、掲載まで日数がかかる場合があります。
              </p>
              @else
              <div class="my-3">
                <p class="after-text h3 mb-4">掲載中の求人票の内容を更新しました！</p>
              </div>
              <p>変更後も引き続き、掲載中の状態となります。<br>
                不適切な内容と判断された場合、求人票が停止されます。<br>
              </p>
              @endif
            </div>
          </div> <!-- card -->
          <div class="form-group text-center">
            <a class="btn back-btn ml-3" href="javascript:void(0);" onClick="window.opener.location.reload(),window.close()"><i class="fas fa-reply mr-3"></i>閉じる</a>
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
