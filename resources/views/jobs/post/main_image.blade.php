@extends('layouts.employer_mypage_master')

@section('title', 'メイン写真の登録| JOB CiNEMA')
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
        
        <form class="file-apload-form" action="@if($job){{route('main.image.post', [$job->id])}}@else{{route('main.image.post')}}@endif" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="data[File][currentPath]" value="@if($job == '' && Session::has('data.file.image.main')){{Session::get('data.file.image.main')}}@elseif($job != '' && Session::has('data.file.edit_image.main') && Session::get('data.file.edit_image.main') != ''){{Session::get('data.file.edit_image.main')}}@elseif($job != '' && Session::has('data.file.edit_image.main') == false && $job->job_img != null){{$job->job_img}}@else '/uploads/images/no-image.gif' @endif" id="FileCurrentPath">
        <input type="hidden" name="imageFlag" value="main">
            <div class="card">
        
                <div class="card-header">メイン写真の登録</div>
                <div class="card-body">
                        <p>ファイルを選択から登録したい画像を選んでください</p>
                        <div class="my-5">
                            <input name="data[File][image]" type="file" id="FileImage" accept=".jpg,.gif,.png,image/gif,image/jpeg,image/png">
                        </div>
                        @if($job == '' && Session::has('data.file.image.main'))
                        <p>現在登録されている画像</p>
                        <p class="pre-main-image"><img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{Session::get('data.file.image.main')}}@else{{Session::get('data.file.image.main')}}@endif" alt="写真を登録してください"></p>
                        @elseif($job != '' && Session::has('data.file.edit_image.main') && Session::get('data.file.edit_image.main') != '')
                        <p>現在登録されている画像</p>
                        <p class="pre-main-image"><img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{Session::get('data.file.edit_image.main')}}@else{{Session::get('data.file.edit_image.main')}}@endif" alt="写真を登録してください"></p>
                        @elseif($job != '' && Session::has('data.file.edit_image.main') == false && $job->job_img != null)
                        <p>現在登録されている画像</p>
                        <p class="pre-main-image"><img src="@if(config('app.env') == 'production'){{config('app.s3_url')}}{{$job->job_img}}@else{{$job->job_img}}@endif" alt="写真を登録してください"></p>
                        @endif
                        <ul class="list-unstyled">
                            <li>画像はjpg/gif/png形式に対応しています。</li>
                            <li>画像のサイズは280×210ピクセルです。
サイズの違う画像は自動的にサイズ調整されます。</li>
                            <li>登録できるファイルサイズは20MBまでです。</li>
                        </ul>
                </div>
            </div> <!-- card --> 
            <div class="form-group text-center">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary">登録する</button>

                    <a href="javascript:void(0);" class="btn btn-secondary" id="deleteImage">登録された画像を削除</a>
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

    $('#deleteImage').click(function() {
        if(window.confirm('登録されているメイン写真を削除します。よろしいですか？')) {
            
            if(job != '') {
                window.location.href = '/company/job/create/main/image/delete/' + job.id + '?imageflag=main';
            } else {
                window.location.href = '/company/job/create/main/image/delete?imageflag=main';
            }

            window.opener.$("#photo1").attr('src', '/uploads/images/no-image.gif');
            window.opener.$('#FileIsExist1').val(0); 
        
            return false;
        }
    });
});
</script>

@endsection


