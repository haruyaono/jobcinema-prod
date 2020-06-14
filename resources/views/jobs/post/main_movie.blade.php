@extends('layouts.employer_mypage_master')

@section('title', 'メイン動画の登録| JOB CiNEMA')
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
        @if(count($errors) > 0)
            <div class="alert alert-danger">
            <strong><i class="fas fa-exclamation-circle"></i>エラー</strong><br>
                <ul class="list-unstyled">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('message_success'))
            <div class="alert alert-success">
                {{ Session::get('message_success') }}
            </div>
        @endif
        @if(Session::has('message_danger'))
            <div class="alert alert-danger">
                {{ Session::get('message_danger') }}
            </div>
        @endif
        <form class="file-apload-form" action="@if($job){{route('main.movie.post', [$job->id])}}@else{{route('main.movie.post')}}@endif" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="movieFlag" value="main">
            <div class="card">
                <div class="card-header">メイン動画の登録</div>
                <div class="card-body">
                        <p>ファイルを選択から登録したい動画を選んでください</p>
                        <div class="my-5">
                            <input name="data[File][movie]" type="file" id="job_main_mov" accept="video/*">
                        </div>
                        @if($job == '' && Session::has('data.file.movie.main'))
                        <p>現在登録されている動画</p>
                        <p oncontextmenu="return false;" class="pre-main-movie">
                            <video controls controlsList="nodownload" preload="none" playsinline>
                                <source src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{Session::get('data.file.movie.main')}}@else{{Session::get('data.file.movie.main')}}@endif"/></iframe>
                            </video>
                        </p>
                        @elseif($job != '' && Session::has('data.file.edit_movie.main') && Session::get('data.file.edit_movie.main') != '')
                        <p>現在登録されている動画</p>
                        <p oncontextmenu="return false;" class="pre-main-movie">
                            <video controls controlsList="nodownload" preload="none" playsinline>
                                <source src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{Session::get('data.file.edit_movie.main')}}@else{{Session::get('data.file.edit_movie.main')}}@endif"/></iframe>
                            </video>
                        </p>
                        @elseif($job != '' && Session::has('data.file.edit_movie.main') == false && $job->job_mov != null)
                        <p>現在登録されている動画</p>
                        <p oncontextmenu="return false;" class="pre-main-movie">
                            <video controls controlsList="nodownload" preload="none" playsinline>
                                <source src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{$job->job_mov}}@else{{$job->job_mov}}@endif"/></iframe>
                            </video>
                        </p>
                        @endif
                        <ul class="list-unstyled">
                            <li>動画はMP4/MOV/WMV/MPEG/MPG/AVI形式に対応しています。</li>
                            <li>動画のサイズは480×310ピクセルです。
サイズの違う動画は自動的にサイズ調整されます。</li>
                            <li>登録できるファイルサイズは80MBまでです。</li>
                        </ul>
                </div>
            </div> <!-- card --> 
            <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary" id="submit">登録する</button>
                    <a href="javascript:void(0);" class="btn btn-secondary" id="deleteMovie">登録されている動画を削除</a>
                    <a class="create-image-back-btn" href="javascript:void(0);"　class="btn btn-outline-secondary" id="close_button">戻る</a>
            </div>
        </form>
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

    $('#deleteMovie').click(function() {
        if(window.confirm('登録されているメイン動画を削除します。よろしいですか？')) {
            
            if(job != '') {
                window.location.href = '/company/job/create/main/movie/delete/' + job.id + '?movieflag=main';
            } else {
                window.location.href = '/company/job/create/main/movie/delete?movieflag=main';
            }

            window.opener.$("#film1").attr('src', '');
            window.opener.$('#FileMovieIsExist1').val(0);
        
            return false;
        }
    });

    
});
</script>

@endsection




