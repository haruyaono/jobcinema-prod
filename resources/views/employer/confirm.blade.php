@extends('layouts.employer_form_master')

@section('title', '会社情報確認 | JOB CiNEMA')
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
        求人企業様のご登録
  </li>
</ol>
</div>
<div class="main-wrap">
    <section class="main-section emp-register-section">
		<div class="inner">
			<div class="pad">
          <div class="d-flex d-no-flex">
            <h2 class="txt-h2">求人企業様のご登録</h2>
            <div class="emp-register-flow text-center d-inline-block">入力画面 -> <span class="emp-register-label bg-danger">確認画面</span> -> 仮登録完了</div>
          </div> 
            <div class="col-md-12 p-0 mt-1">
                    <form class="form-horizontal" method="POST" action="{{ route('employer.register') }}" aria-label="{{ __('Register') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="email" value="{{$email}}">
                    <input type="hidden" name="password" value="{{$password}}">
                    <input type="hidden" name="cname" value="{{$cname}}">
                    <input type="hidden" name="e_last_name" value="{{$e_last_name}}">
                    <input type="hidden" name="e_first_name" value="{{$e_first_name}}">
                    <input type="hidden" name="e_phone1" value="{{$e_phone1}}">
                    <input type="hidden" name="e_phone2" value="{{$e_phone2}}">
                    <input type="hidden" name="e_phone3" value="{{$e_phone3}}">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">メールアドレス</th>
                                    <td>{{$email}}</td>
                                </tr>
                                <tr>
                                <th scope="row">パスワード</th>
                                <td>
                                {{$password_mask}}
                                <!-- <input size="45" id="password" type="password"  name="password" disabled="disabled" value="{{$password}}"> -->
                                </td>
                                </tr>
                                <tr>
                                <th scope="row">会社名（店舗名）</th>
                                <td colspan="2">{{$cname}}</td>
                                </tr>
                                <tr>
                                <th scope="row">ご担当者様のお名前</th>
                                <td colspan="2">{{$e_last_name}} {{$e_first_name}}</td>
                                </tr>
                                <tr>
                                <th scope="row">ご担当者様の電話番号</th>
                                <td colspan="2">{{$e_phone1}}-{{$e_phone2}}-{{$e_phone3}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group row mb-5">
                            <p>内容にお間違いなければ「登録する」ボタンをクリックしてください。</p>
                            <div class="col-md-12 mt-3 text-center">
                              <a href="/employer/getpage" class="d-inline-block mr-3">修正する</a>
                              <button type="submit" name="action" value="post" class="btn btn-primary d-inline-block">登録する</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </section>
</div>
@endsection

@section('footer')
@component('components.employer.form_footer')
  @endcomponent
@endsection