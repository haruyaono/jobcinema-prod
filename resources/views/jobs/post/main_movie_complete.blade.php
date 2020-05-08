@extends('layouts.employer_mypage_master')

@section('title', '求人票| JOB CiNEMA')
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
                            <p class="after-text">メイン動画を登録しました。</p>
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
    var job = @json($job);

    data1 = $().setBaseImageUrlAndSetEnvName();


    if(job != '') {
        window.opener.$("#film1").attr('src', data1['base_image_url'] + "{{Session::get('data.file.edit_movie.main')}}");
    } else {
        window.opener.$("#film1").attr('src', data1['base_image_url'] + "{{Session::get('data.file.movie.main')}}");
    }


});
</script>
 
@endsection




