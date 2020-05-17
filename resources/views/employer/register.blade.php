@extends('layouts.employer_form_master')

@section('title', '会社情報登録　| JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.employer.form_header')
  @endcomponent
@endsection

@section('contents')
<!-- パンくず -->
<div id="breadcrumb" class="bread only-pc">
<ol>
  <li>
    <a href="/">
      <i class="fa fa-home"></i><span>TOP</span>
    </a>
  </li>
  <li>
        求人企業様の登録
  </li>
</ol>
</div>
<div class="main-wrap">
    <section class="main-section emp-register-section">
		<div class="inner">
			<div class="pad">
                <div class="d-flex d-no-flex">
                    <h2 class="txt-h2 d-inline-block">求人企業様のご登録<span class="ml-3 text-danger h6 text-muted"><br class="only-sp">※仮登録になります</span></h2>
                    <div class="emp-register-flow text-center d-inline-block"><span class="emp-register-label bg-danger">入力画面</span> -> 確認画面 -> 仮登録完了</div>
                </div>
                <p class="mt-0">ご登録された内容の変更希望のにつきましては、サポートまでお問い合わせください。</p>
                <p class="mt-0 mb-4">電話番号 <span class="header-tel">080-8297-8600</span>(受付時間: 〇〇〜〇〇)</p>
                
                
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
           
                
                <div class="col-md-12 p-0">
                  
                    <form class="form-horizontal" method="POST" action="{{ route('employer.confirm') }}" aria-label="{{ __('Register') }}">
                        {{ csrf_field() }}
                            <table class="table table-bordered">
                            <tbody>
                                <tr>
                                <th scope="row">メールアドレス</th>
                                <td>
                                <input size="65" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }} @if(!old('email')){{Session::get('setdata.email')}}@endif" required>
                                </td>
                                </tr>
                                <tr>
                                <th scope="row">パスワード</th>
                                <td>
                                <input size="45" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} " name="password" required>
                                </td>
                                </tr>
                                <tr>
                                <th scope="row">確認用パスワード</th>
                                <td colspan="2">
                                    <input size="45" type="password" class="form-control" name="password_confirmation" required>  
                                </td>
                                </tr>
                                <tr>
                                <th scope="row">会社名（店舗名）</th>
                                <td colspan="2">
                                    <input size="65" type="text" class="form-control{{ $errors->has('cname') ? ' is-invalid' : '' }}" name="cname" value="{{ old('cname') }}@if(!old('cname')){{Session::get('setdata.cname')}}@endif" required>
                                </td>
                                </tr>
                                <tr>
                                <th scope="row">ご担当者様のお名前</th>
                                <td colspan="2">
                                        <input size="28" type="text" class="emp-register-nameform form-control {{ $errors->has('e_last_name') ? ' is-invalid' : '' }}" name="e_last_name" value="{{ old('e_last_name') }}@if(!old('e_last_name')){{Session::get('setdata.e_last_name')}}@endif" required>
                                         <input size="28" type="text" class="emp-register-nameform form-control {{ $errors->has('e_first_name') ? ' is-invalid' : '' }}" name="e_first_name" value="{{ old('e_first_name') }}@if(!old('e_first_name')){{Session::get('setdata.e_first_name')}}@endif" required>   
                                </td>
                                </tr>
                                <tr>
                                <th scope="row">ご担当者様の電話番号</th>
                                <td colspan="2">
                                    <div class="form-row m-0">
                                        <input size="18" class="form-control col-md-2 {{ $errors->has('e_phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="e_phone1" value="{{ old('e_phone1') }}@if(!old('e_phone1')){{Session::get('setdata.e_phone1')}}@endif" required>
                                        &nbsp;-&nbsp;
                                        <input size="18" class="form-control col-md-2 {{ $errors->has('e_phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="e_phone2" value="{{ old('e_phone2') }}@if(!old('e_phone2')){{Session::get('setdata.e_phone2')}}@endif" required>
                                        &nbsp;-&nbsp;
                                        <input size="18" class="form-control col-md-2 {{ $errors->has('e_phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="e_phone3" value="{{ old('e_phone3') }}@if(!old('e_phone3')){{Session::get('setdata.e_phone3')}}@endif" required>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group row mb-5">
                            
                                <!-- <p>ご登録前に<a href="">利用規約</a>と<a href="">プライバシーポリシー</a>をご確認ください。</p> -->
                                <p>ご登録前に<a href="/terms_service_e" class="d-inline-block txt-blue-link">利用規約</a>をご確認ください。</p>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('同意して確認する') }}
                                    </button>
                                </div>  
                        </div>
                    </form>
                    <div class="text-center mb-5">
                        <p class="text-danger">※もし仮登録完了メールが届かない場合は下記から再送してください</p>
                        <a class="txt-blue-link" href="{{ url('/employer/verify/resend') }}">本登録用メールを再送する</a>
                    </div>
                    
                    <ul class="emp-form-pagetop-list mb-1">
                        <li><i class="far fa-arrow-alt-circle-right mr-1"></i><a href="/">HOME</a></li>
                        <li><i class="far fa-arrow-alt-circle-up mr-1"></i><a href="">ページトップへ</a></li>
                    </ul>
                </div>
            </div>  <!-- pad -->
        </div>  <!-- inner --> 
    </section>
</div> <!-- main-wrap -->

@endsection

@section('footer')
  @component('components.employer.form_footer')
  @endcomponent
@endsection