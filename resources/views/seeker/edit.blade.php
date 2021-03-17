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
            <a href="{{ route('seeker.index.mypage') }}">
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
                    <div class="col-12 mt-3 px-0">
                        <div class="card mypage-card">
                            <div class="card-header">会員情報編集</div>

                            <form action="{{ route('seeker.update.profile') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body text-left">
                                    <div class="form-group">
                                        <label class="d-block" for="">お名前(カナ)（必須）</label>
                                        <div class="mypage-nameform">
                                            <input type="text" class="form-control {{ $errors->has('data.user.last_name') ? 'is-invalid' : '' }}" name="data[user][last_name]" value="{{ old('data.user.last_name') ?: $user->last_name }}">
                                        </div>
                                        <div class="mypage-nameform">
                                            <input type="text" class="form-control {{ $errors->has('data.user.first_name') ? 'is-invalid' : '' }}" name="data[user][first_name]" value="{{ old('data.user.first_name') ?: $user->first_name }}">
                                        </div>
                                        <div class="text-danger">※ひらがな、もしくはカタカナでご入力下さい</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">連絡先電話番号（必須）</label>
                                        <div class="form-row">
                                            <input class="form-control form-control-sm col-3 {{ $errors->has('data.profile.phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="data[profile][phone1]" value="{{ old('data.profile.phone1') ?: $profile->phone1 }}" required>
                                            &nbsp;-&nbsp;
                                            <input class="form-control form-control-sm col-3 {{ $errors->has('data.profile.phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="data[profile][phone2]" value="{{ old('data.profile.phone2') ?: $profile->phone2 }}" required>
                                            &nbsp;-&nbsp;
                                            <input class="form-control form-control-sm col-3 {{ $errors->has('data.profile.phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="data[profile][phone3]" value="{{ old('data.profile.phone3') ?: $profile->phone3 }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="d-block" for="">年齢（必須）</label>
                                        <input type="text" class="form-control w-25 d-inline-block {{ $errors->has('data.profile.age') ? 'is-invalid' : '' }}" name="data[profile][age]" value="{{ old('data.profile.age') ?: $profile->age }}"> <span>歳</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">性別</label><br>
                                        <input id="1" type="radio" name="data[profile][gender]" value="男性" @if($profile->gender == "男性") checked @endif {{ old('data.profile.gender') == '男性' ? 'checked' : '' }}> <label for="1">男性</label>
                                        <input id="2" type="radio" name="data[profile][gender]" value="女性" @if($profile->gender == "女性") checked @endif {{ old('data.profile.gender') == '女性' ? 'checked' : '' }}> <label for="2">女性</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="">住所</label>
                                        <div class="form-row m-0">
                                            <input class="form-control form-control-sm col-3 {{ $errors->has('data.profile.postcode01') ? 'is-invalid' : '' }}" placeholder="000" type="text" name="data[profile][postcode01]" maxlength="3" value="@if(old('data.profile.postcode01')){{ old('data.profile.postcode01')}}@else{{ count($postcode) !== 0 ? $postcode[0] : '' }}@endif">&nbsp;-&nbsp;<input class="form-control form-control-sm col-4 {{ $errors->has('data.profile.postcode02') ? 'is-invalid' : '' }}" placeholder="0000" type="text" name="data[profile][postcode02]" maxlength="4" value="@if(old('data.profile.postcode02')){{ old('data.profile.postcode02')}}@else{{ count($postcode) !== 0 ? $postcode[1] : '' }}@endif" onKeyUp="AjaxZip3.zip2addr('data[profile][postcode01]','data[profile][postcode02]','data[profile][prefecture]', 'data[profile][city]');">
                                        </div>
                                        <input class="form-control form-control-sm mt-3 col-8 {{ $errors->has('data.profile.prefecture') ? 'is-invalid' : '' }}" placeholder="都道府県" type="text" name="data[profile][prefecture]" value="{{ old('data.profile.prefecture') ?: $profile->prefecture }}">
                                        <input class="form-control form-control-sm mt-3 {{ $errors->has('data.profile.city') ? 'is-invalid' : '' }}" placeholder="市区町村" type="text" name="data[profile][city]" value="{{ old('data.profile.city') ?: $profile->city }}">
                                        <input class="form-control form-control-sm mt-3 {{ $errors->has('data.profile.address') ? 'is-invalid' : '' }}" placeholder="丁目番地" type="text" name="data[profile][address]" value="{{ old('data.profile.address') ?: $profile->address }}">
                                        <input class="form-control form-control-sm mt-3 {{ $errors->has('data.profile.building') ? 'is-invalid' : '' }}" placeholder="建物名" type="text" name="data[profile][building]" value="{{ old('data.profile.building') ?: $profile->building }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">口座情報</label>
                                        <input class="form-control form-control-sm mt-3 {{ $errors->has('data.profile.bank_name') ? 'is-invalid' : '' }}" placeholder="銀行名" type="text" name="data[profile][bank_name]" value="{{ old('data.profile.bank_name') ?: $profile->bank_name }}">
                                        <input class="form-control form-control-sm mt-3 {{ $errors->has('data.profile.branch_name') ? 'is-invalid' : '' }}" placeholder="支店名" type="text" name="data[profile][branch_name]" value="{{ old('data.profile.branch_name') ?: $profile->branch_name }}">
                                        <select name="data[profile][account_type]">
                                            <option>口座タイプ</option>
                                            <option value="普通" @if(old('data.profile.account_type') == "普通" || $profile->account_type == "普通") selected @endif>普通</option>
                                            <option value="当座" @if(old('data.profile.account_type') == "普通" || $profile->account_type == "普通") selected @endif>当座</option>
                                        </select>
                                        <input class="form-control form-control-sm mt-3 {{ $errors->has('data.profile.account_number') ? 'is-invalid' : '' }}" placeholder="口座番号" type="text" name="data[profile][account_number]" value="{{ old('data.profile.account_number') ?: $profile->account_number }}">
                                        <input class="form-control form-control-sm mt-3 {{ $errors->has('data.profile.account_name') ? 'is-invalid' : '' }}" placeholder="口座名" type="text" name="data[profile][account_name]" value="{{ old('data.profile.account_name') ?: $profile->account_name }}">
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
                    <p class="mt-5"><i class="fas fa-arrow-left mr-1"></i><a href="{{ route('seeker.index.mypage') }}" class="txt-blue-link">前に戻る</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection
