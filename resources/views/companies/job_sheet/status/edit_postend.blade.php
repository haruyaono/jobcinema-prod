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
                <p class="after-text h3　mb-5">掲載中ですが掲載を終了してよろしいですか？</p>
              </div>
              <form name="JobSheetstatus" action="{{ route('enterprise.update.jobsheet.status.postend', [$jobitem]) }}" method="POST" class="text-center">
                @csrf
                @method('PUT')
                <input type="hidden" name="data[JobSheet][pushed]" value="updatePostend">
                <input type="hidden" name="data[JobSheet][id]" value="{{ $jobitem->id }}">
                <button type="button" class="btn btn-secondary" id="updateJobSheetStatus">掲載をやめる</button>
              </form>
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

@section('js')
<script>
  $(function() {
    $('#updateJobSheetStatus').click(function() {
      event.preventDefault();
      if (window.confirm('掲載をやめます、よろしいですか？')) {
        document.JobSheetstatus.submit();
      }
    });
  });
</script>

@endsection
