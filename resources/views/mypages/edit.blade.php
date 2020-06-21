@extends('layouts.master')

@section('title', '会員情報編集 | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.header')
  @endcomponent
@endsection

@section('contents')
<!-- パンくず -->
<div id="breadcrumb" class="bread only-pc">
<ol>
  <li>
    <a href="/mypage/index">
     　マイページ
    </a>
  </li>
  <li>
        会員情報編集
  </li>
</ol>
</div>

<section class="main-section">
		<div class="inner">
			<div class="pad">
                <h2 class="txt-h2 mb-3">会員情報</h2>
                @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
<div class="container mypage-container px-1">
    <div class="row justify-content-around w-100 m-0">
        <div class="col-12 col-lg-6 col-md-6 col-sm-12 mt-3 px-0">
            <div class="card mypage-card">
                <div class="card-header">会員情報編集</div>

                <form action="{{ route('user.profile.post') }}" method="POST">
                @csrf

                <div class="card-body text-left">
                    <div class="form-group">
                        <label class="d-block" for="">お名前(カナ)（必須）</label>
                        <div class="mypage-nameform">
                            <input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" name="last_name" value="{{old('last_name') ? old('last_name') : Auth::user()->last_name}}">
                        </div>
                        <div class="mypage-nameform">
                            <input type="text" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" name="first_name" value="{{old('first_name') ? old('first_name') : Auth::user()->first_name}}">
                        </div>
                        <div class="text-danger">※ひらがな、もしくはカタカナでご入力下さい</div>
                    </div>
                    <div class="form-group">
                        <label for="">連絡先電話番号（必須）</label>
                        <div class="form-row">
                            <input class="form-control form-control-sm col-3 {{ $errors->has('phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="phone1" value="{{old('phone1')}}@if(!old('phone1')){{ $profile->phone1}}@endif" required>
                            &nbsp;-&nbsp;
                            <input class="form-control form-control-sm col-3 {{ $errors->has('phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="phone2" value="{{old('phone2')}}@if(!old('phone2')){{ $profile->phone2}}@endif" required>
                            &nbsp;-&nbsp;
                            <input class="form-control form-control-sm col-3 {{ $errors->has('phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="phone3" value="{{old('phone3')}}@if(!old('phone3')){{ $profile->phone3}}@endif" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="d-block" for="">年齢（必須）</label>
                        <input type="text" class="form-control w-25 d-inline-block {{ $errors->has('age') ? 'is-invalid' : '' }}" name="age" value="{{old('age') ? old('age') : $profile->age}}"> <span>歳</span>
                    </div>
                    <div class="form-group">
                        <label for="">性別</label><br>
                        <input id="1" type="radio" name="gender" value="男性" @if($profile->gender == "男性") checked @endif {{ old('gender','男性') == '男性' ? 'checked' : '' }}> <label for="1">男性</label>
                        <input id="2" type="radio" name="gender" value="女性" @if($profile->gender == "女性") checked @endif {{ old('gender') == '女性' ? 'checked' : '' }}> <label for="2">女性</label>
                    </div>
                    <div class="form-group">
                        <label for="">住所</label>
                        <div class="form-row m-0">
                            <input class="form-control form-control-sm col-3 {{ $errors->has('zip31') ? 'is-invalid' : '' }}" type="text" name="zip31" maxlength="3" value="{{old('zip31') ? old('zip31') : $profile->postcode1}}">&nbsp;-&nbsp;<input class="form-control form-control-sm col-4 {{ $errors->has('zip32') ? 'is-invalid' : '' }}" type="text" name="zip32" maxlength="4" value="{{old('zip32') ? old('zip32') : $profile->postcode2}}" onKeyUp="AjaxZip3.zip2addr('zip31','zip32','pref31','addr31','addr31');">
                        </div>
                        <input class="form-control form-control-sm mt-3 col-8 {{ $errors->has('pref31') ? 'is-invalid' : '' }}" type="text" name="pref31" value="{{old('pref31') ? old('pref31') : $profile->prefecture}}">
                        <input class="form-control form-control-sm mt-3 {{ $errors->has('addr31') ? 'is-invalid' : '' }}" type="text" name="addr31" value="{{old('addr31') ? old('addr31') : $profile->city}}">
                        <div class="text-danger">※番地や建物名は不要です</div>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn mt-2" type="submit">更新</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>

        </div>

        <div class="col-12 col-md-5 mt-3 px-0">
            <div class="card mypage-card">
                <div class="card-header">プロフィール</div>
                <div class="card-body table-responsive text-left">
                    <table class="table text-nowrap">
                        <tr>
                            <th>お名前&nbsp</th>
                            <td>
                                @if(Auth::user()->last_name == '' && Auth::user()->last_name == '')未登録@endif
                                {{ Auth::user()->last_name ? Auth::user()->last_name : ''}}&nbsp{{ Auth::user()->first_name ? Auth::user()->first_name : ''}}
                            </td>
                        </tr>
                        <tr>
                            <th>電話番号&nbsp</th>
                            <td>
                                {{ $profile->phone1 && $profile->phone2 && $profile->phone3 ? $profile->phone1 . '-' . $profile->phone2 .'-'. $profile->phone3 : '未登録'}}
                            </td>
                        </tr>
                        <tr>
                            <th>メールアドレス&nbsp</th>
                            <td>
                                {{ Auth::user()->email ? Auth::user()->email : '未登録'}}
                            </td>
                        </tr>
                        <tr>
                            <th>年齢&nbsp</th>
                            <td>
                                {{ $profile->age ? $profile->age.'歳' : '未登録'}} 
                            </td>
                        </tr>
                        <tr>
                            <th>性別&nbsp</th>
                            <td>
                                {{ $profile->gender ? $profile->gender : '未登録'}}
                            </td>
                        </tr>
                        <tr>
                            <th>住所&nbsp</th>
                            <td>
                            @if($profile->postcode == '' && $profile->prefecture == '' && $profile->city == '')未登録@endif
                            {{ $profile->postcode ? $profile->postcode : ''}}<br>
                            {{ $profile->prefecture ? $profile->prefecture : ''}}&nbsp{{ $profile->city ? $profile->city : ''}}
                            </td>
                        </tr>
                        <tr>
                            <th>履歴書&nbsp</th>
                            <td>
                                @if(!is_null($profile->resume) && $profile->resumePath !== '')
                                    <p>
                                        <a class="d-inline-block txt-blue-link" href="{{ $profile->resumePath }}" target="_blank">
                                            履歴書
                                        </a>
                                        {!! Form::open(['url' => route('resume.delete'), 'method' => 'post']) !!}
                                        {{ method_field('DELETE') }}
                                            <button class="border mt-1">削除</button>
                                        {!! Form::close() !!}   
                                    </p>
                                @else
                                    <p>未登録</p>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <form class="file-upload-form" action="{{ route('user.resume.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mt-3 mypage-card">
                    <div class="card-header">履歴書</div>
                    <div class="card-body">
                        <input type="file" class="form-control resume-input" name="resume" accept="application/pdf">
                        <button class="btn btn-success mt-3" type="submit">更新</button>
                        @if($errors->has('resume'))
                            <div class="error" style="color: red;">{{ $errors->first('resume') }}</div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<p class="mt-5"><i class="fas fa-arrow-left mr-1"></i><a href="{{route('mypages.index')}}" class="txt-blue-link">前に戻る</a></p>

</div>
</div>  
</section>
</div>
@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection
