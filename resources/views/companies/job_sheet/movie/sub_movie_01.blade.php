@extends('layouts.employer_mypage_master')

@section('title', 'サブ動画１の登録 | JOB CiNEMA')
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
                    <form class="file-apload-form" action="{{route('update.jobsheet.submovie1', [$jobitem])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="data[JobSheet][id]" value="{{$jobitem->id}}" id="JobSheetId" />
                        <input type="hidden" name="data[File][suffix]" value="2" id="FileSuffix" />
                        @if($jobitem->job_mov_2)
                        <input type="hidden" name="data[File][currentPath]" value="@if(config('app.env') == 'production'){{ config('app.s3_url') . '/mov/uploads/JobSheet/' . $jobitem->job_mov_2 . '?' . date('YmdHis') }}@else{{'https://job-cinema-dev.s3-ap-northeast-1.amazonaws.com/mov/uploads/JobSheet/' . $jobitem->job_mov_2 . '?' . date('YmdHis') }}@endif" id="FileCurrentPath">
                        @else
                        <input type="hidden" name="data[File][currentPath]" value="" id="FileCurrentPath">
                        @endif
                        <div class="card">
                            <div class="card-header">サブ動画の登録</div>
                            <div class="card-body">
                                <p>ファイルを選択から登録したい動画を選んでください</p>
                                <div class="my-5">
                                    <input name="data[File][movie]" type="file" id="job_main_mov" accept="video/*">
                                </div>
                                <p class="mb-2">現在登録されている動画</p>
                                @if($jobitem->job_mov_2)
                                <p class="pre-main-image">
                                    <video src="@if(config('app.env') == 'production'){{ config('app.s3_url') . '/mov/uploads/JobSheet/' . $jobitem->job_mov_2 . '?' . date('YmdHis') }}@else{{'https://job-cinema-dev.s3-ap-northeast-1.amazonaws.com/mov/uploads/JobSheet/' . $jobitem->job_mov_2 . '?' . date('YmdHis') }}@endif" controls controlsList="nodownload" preload="none" playsinline width="100%">
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
                            <button type="submit" class="btn btn-primary">登録する</button>
                            <a href="javascript:void(0);" class="btn btn-secondary" id="deleteMovie">登録されている動画を削除</a>
                            <a class="create-image-back-btn" href="javascript:void(0);" 　class="btn btn-outline-secondary" id="close_button">戻る</a>
                        </div>
                    </form>
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
        var job = @json($jobitem);
        var moviePath = $('#FileCurrentPath').attr('value');

        if (moviePath != '') {
            window.opener.$('#film2').attr('src', moviePath);
        } else {
            window.opener.$('#film2').attr('src', '');
        }

        $('#deleteMovie').click(function() {
            if (window.confirm('登録されているサブ動画を削除します。よろしいですか？')) {
                window.location.href = '/company/jobs/create/delete_movie/' + job.id + '?flag=2';
                return false;
            }
        });
    });
</script>

@endsection
