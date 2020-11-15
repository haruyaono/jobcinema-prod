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
                <p class="mt-0">ご登録された内容の変更希望のにつきましては、お問い合わせフォームからお問い合わせください。</p>
                <!-- <p class="mt-0 mb-4">電話番号 <span class="header-tel">080-8297-8600</span>(受付時間: 〇〇〜〇〇)</p> -->

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
                    <form class="form-horizontal" method="POST" action="{{route('employer.confirm') }}" aria-label="{{ __('Register') }}">
                        {{ csrf_field() }}
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">メールアドレス</th>
                                    <td>
                                        <input size="65" type="email" class="form-control {{ $errors->has('company_form.email') ? ' is-invalid' : '' }}" name="company_form[email]" value="{{ old('company_form.email') ?: Session::get('company_form.email') }}" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">パスワード</th>
                                    <td>
                                        <input size="45" type="password" class="form-control{{ $errors->has('company_form.password') ? ' is-invalid' : '' }} " name="company_form[password]" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">確認用パスワード</th>
                                    <td colspan="2">
                                        <input size="45" type="password" class="form-control" name="company_form[password_confirmation]" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">企業名（店舗名）</th>
                                    <td colspan="2">
                                        <input size="65" type="text" class="form-control{{ $errors->has('company_form.cname') ? ' is-invalid' : '' }}" name="company_form[cname]" value="{{ old('company_form.cname') ?: Session::get('company_form.cname') }}" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ご担当者様のお名前</th>
                                    <td colspan="2">
                                        <input size="28" type="text" class="emp-register-nameform form-control {{ $errors->has('company_form.last_name') ? ' is-invalid' : '' }}" name="company_form[last_name]" value="{{ old('company_form.last_name') ?: Session::get('company_form.last_name') }}" required>
                                        <input size="28" type="text" class="emp-register-nameform form-control {{ $errors->has('company_form.first_name') ? ' is-invalid' : '' }}" name="company_form[first_name]" value="{{ old('company_form.first_name') ?: Session::get('company_form.first_name') }}" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ご担当者様の電話番号
                                    </th>
                                    <td colspan="2">
                                        <div class="form-row m-0">
                                            <input size="18" class="form-control col-md-2 {{ $errors->has('company_form.phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="company_form[phone1]" value="{{ old('company_form.phone1') ?: Session::get('company_form.phone1') }}" required>
                                            &nbsp;-&nbsp;
                                            <input size="18" class="form-control col-md-2 {{ $errors->has('company_form.phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="company_form[phone2]" value="{{ old('company_form.phone2') ?: Session::get('company_form.phone1') }}" required>
                                            &nbsp;-&nbsp;
                                            <input size="18" class="form-control col-md-2 {{ $errors->has('company_form.phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="company_form[phone3]" value="{{ old('company_form.phone3') ?: Session::get('company_form.phone1') }}" required>
                                        </div>
                                        <p>※運営との連絡用お電話番号です</p>
                                        <p class="m-0">※求職者には非公開</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group row mb-5">
                            <p>ご登録前に<a href="/terms_service_e" class="d-inline-block txt-blue-link" target="_blank">利用規約</a>をご確認ください。</p>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('同意して確認する') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="text-center mb-5">
                        <p class="text-danger">※もし仮登録完了メールが届かない場合は下記から再送してください</p>
                        <a class="txt-blue-link" href="{{ route('index.mailform.resend.preregister') }}">本登録用メールを再送する</a>
                    </div>

                    <ul class="emp-form-pagetop-list mb-1">
                        <li><i class="far fa-arrow-alt-circle-right mr-1"></i><a href="/">HOME</a></li>
                        <li><i class="far fa-arrow-alt-circle-up mr-1"></i><a href="">ページトップへ</a></li>
                    </ul>
                </div>
            </div> <!-- pad -->
        </div> <!-- inner -->
    </section>
</div> <!-- main-wrap -->

@endsection

@section('footer')
@component('components.employer.form_footer')
@endcomponent
@endsection
