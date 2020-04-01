@extends('layouts.employer_form_master')

@section('title', '会社情報登録　| JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.employer.form_header')
  @endcomponent
@endsection

@section('contents')
<div class="main-wrap">
<section class="main-section emp-main-register-section">
<div class="inner">
<div class="pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 p-0 text-center">
                <h2 class="txt-h2 my-5">本登録が完了しました</h2>
                <a href="{{route('employer.login')}}" class="btn my-5">ログインする</a>
            </div>
        </div><!-- row -->
    </div> <!-- container -->
</div>  <!-- pad -->
</div>  <!-- inner --> 
</section>
</div> <!-- main-wrap -->
@endsection

@section('footer')
  @component('components.employer.form_footer')
  @endcomponent
@endsection