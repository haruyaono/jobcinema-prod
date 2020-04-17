@extends('layouts.employer_mypage_master')

@section('title', 'サブ写真の登録完了| JOB CiNEMA')
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
                            <p class="after-text">サブ写真を登録しました。</p>
                        </div>
                </div>
            </div> <!-- card --> 
            <div class="form-group text-center">
            <a href="javascript:void(0);" class="btn btn-dark" id="close_button">OK</a>
            </div>
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


@section('js')
<script>

$(function() {
    var job = @json($job),
        suffix = @json($suffix);


    if(job != '') {
      if(suffix == 'sub1') {
        window.opener.$("#photo2").attr('src', "{{Session::get('data.file.edit_image.sub1')}}");
      } else if(suffix == 'sub2') {
        window.opener.$("#photo3").attr('src', "{{Session::get('data.file.edit_image.sub2')}}");
      }
        
    } else {
      if(suffix == 'sub1') {
        window.opener.$("#photo2").attr('src', "{{Session::get('data.file.image.sub1')}}");
      } else if(suffix == 'sub2') {
        window.opener.$("#photo3").attr('src', "{{Session::get('data.file.image.sub2')}}");
      }
    }
   

});
</script>
 
@endsection


