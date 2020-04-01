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
                        <div class="my-3">
                            <p class="after-text　h3">一時保存をしました！</p>
                        </div>
                        <p>一時保存いただいた求人票は<br class="only-pc">
                        「詳細・編集」からいつでも変更可能です。<br>
                        掲載される際には、求人票を「登録」してください。
                        </p>
                </div>
            </div> <!-- card --> 
            <div class="form-group text-center">
                    <a href="javascript:void(0);" class="btn btn-dark" onClick="window.opener.location.reload(),window.close()">閉じる</a>
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




