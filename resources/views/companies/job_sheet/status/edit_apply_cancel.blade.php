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
                <p class="after-text h3">求人票の申請を取り消します</p>
                <p class="text-center mt-3">申請取り消し後の求人票は一時保存ステータスに変更されます。</p>
                <p class="text-center mb-5">編集・再掲載が可能です。</p>
              </div>
              <form name="JobSheetstatus" action="{{route('update.jobsheet.status.apply_cancel', [$jobitem])}}" method="POST" class="text-center">
                @csrf
                @method('PUT')
                <input type="hidden" name="data[JobSheet][pushed]" value="updateApplyCancel">
                <input type="hidden" name="data[JobSheet][id]" value="{{$jobitem->id}}">
                <button type="button" class="btn btn-secondary" id="updateJobSheetStatus">申請取り消し</button>
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
      if (window.confirm('申請を取り消します、よろしいですか？')) {
        document.JobSheetstatus.submit();
      }
    });
  });
</script>

@endsection
