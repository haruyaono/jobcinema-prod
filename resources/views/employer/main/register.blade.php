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
            <div class="col-md-12 p-0">
            @isset($message)
                <div class="card-body">
                    {{$message}}
                    <div class="text-center my-5"><a href="{{route('employer.login')}}">ログインページ</a></div>
                </div>
            @endisset

            @empty($message)
                <h2 class="txt-h2 d-inline-block mb-3">企業専用ページ</h2>
                <p class="mb-5">企業データご登録と同時に本登録が完了します。</p>
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
                <form method="POST" action="{{ route('employer.main.register') }}">
                @csrf
                <input type="hidden" name="email_token" value="{{ $email_token }}">
                <div class="card mb-5">
                        <div class="card-header">ご担当者様データ</div>
                        
                        <div class="card-body">
                            <table class="table table-bordered text-left">
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <label for="" class="col-form-label col-form-label-sm">ご担当者様</label><span class="text-danger ml-1">*</span>
                                        </th>
                                        <td>
                                            <div class="form-row">
                                                <input type="text" size="28"
                                                    class="form-control form-control-sm mr-2{{ $errors->has('e_last_name') ? ' is-invalid' : '' }}"
                                                    name="e_last_name" value="{{old('e_last_name')}}@if(!old('e_last_name')){{$employer->last_name }}@endif" required>
                                                <input type="text" size="28"
                                                class="form-control form-control-sm {{ $errors->has('e_first_name') ? ' is-invalid' : '' }}"
                                                name="e_first_name" value="{{old('e_first_name')}}@if(!old('e_first_name')){{ $employer->first_name }}@endif" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="" class="col-form-label col-form-label-sm">フリガナ</label><span class="text-danger ml-1">*</span>
                                        </th>
                                        <td>
                                            <div class="form-row">
                                                <input type="text" size="28" class="form-control form-control-sm mr-2 {{ $errors->has('e_last_name_katakana') ? ' is-invalid' : '' }}"
                                                        name="e_last_name_katakana" value="{{old('e_last_name_katakana')}}" required>
                                                <input type="text" size="28"
                                                    class="form-control form-control-sm {{ $errors->has('e_first_name_katakana') ? ' is-invalid' : '' }}"
                                                    name="e_first_name_katakana" value="{{ old('e_first_name_katakana')}}" required>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="" class="col-form-label col-form-label-sm">ご担当者様電話番号</label><span class="text-danger ml-1">*</span>
                                        </th>
                                        <td>
                                            <div class="form-row m-0">
                                                <input size="18" class="form-control form-control-sm col-md-2 {{ $errors->has('e_phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="e_phone1" value="{{old('e_phone1')}}@if(!old('e_phone1')){{$employer->phone1}}@endif" required>
                                                &nbsp;-&nbsp;
                                                <input size="18" class="form-control form-control-sm col-md-2 {{ $errors->has('e_phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="e_phone2" value="{{old('e_phone2')}}@if(!old('e_phone2')){{$employer->phone2}}@endif" required>
                                                &nbsp;-&nbsp;
                                                <input size="18" class="form-control form-control-sm col-md-2 {{ $errors->has('e_phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="e_phone3" value="{{old('e_phone3')}}@if(!old('e_phone3')){{$employer->phone3}}@endif" required>
                                            </div>
                                        </td>
                                    </tr>                
                                </tbody>
                            </table>
                        </div>
                    </div><!-- card -->
                    <div class="card mb-5">
                        <div class="card-header">企業データ</div>
                        
                        <div class="card-body">
                            <table class="table table-bordered text-left">
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <label for="cname" class="col-form-label col-form-label-sm">会社名</label><span class="text-danger ml-1">*</span>
                                        </th>
                                        <td>
                                            <input size="65" type="text" class="form-control form-control-sm {{ $errors->has('cname') ? ' is-invalid' : '' }}" name="cname" value="{{!old('cname') ? old('cname') : ''}}{{ $employer->company->cname }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="cname_katakana" class="col-form-label col-form-label-sm">会社名(フリガナ)</label><span class="text-danger ml-1">*</span>
                                        </th>
                                        <td>
                                            <input size="65" type="text" class="form-control form-control-sm {{ $errors->has('cname_katakana') ? ' is-invalid' : '' }}" name="cname_katakana" value="{{ old('cname_katakana') }}" required>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th scope="row">
                                            <label for="" class="ol-form-label col-form-label-sm">本社住所</label><span class="text-danger ml-1">*</span>
                                        </th> 
                                        <td>
                                            <div class="form-row m-0">
                                                〒 <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('zip31') ? 'is-invalid' : '' }}" type="text" name="zip31" maxlength="3" value="{{old('zip31') }}" required>&nbsp;-&nbsp;<input size="28" class="form-control form-control-sm col-md-4 {{ $errors->has('zip32') ? 'is-invalid' : '' }}" type="text" name="zip32" maxlength="4" value="{{old('zip32')}}" onKeyUp="AjaxZip3.zip2addr('zip31','zip32','pref31','addr31','addr31');" required>
                                            </div>
                                            <input size="28" class="form-control form-control-sm mt-3 {{ $errors->has('pref31') ? 'is-invalid' : '' }}" type="text" name="pref31" value="{{ old('pref31') }}" placeholder="例）北海道" required>
                                            <input size="65" class="form-control form-control-sm mt-3 {{ $errors->has('addr31') ? 'is-invalid' : '' }}" type="text" name="addr31" value="{{ old('addr31') }}"　placeholder="例）釧路市 〇〇西 2-24-12" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="ceo" class="col-form-label col-form-label-sm">代表者様</label>
                                        </th>
                                        <td>
                                            <input size="28" type="text" class="form-control form-control-sm {{ $errors->has('ceo') ? ' is-invalid' : '' }}" name="ceo" value="{{old('ceo')}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="" class="col-form-label col-form-label-sm">設立</label><span class="text-danger ml-1">*</span>
                                        </th>
                                        <td>
                                            <label for="f_year">西暦</label>
                                            <input type="text" maxlength="4" size="18" class="form-control form-control-sm col-md-2 d-inline-block {{ $errors->has('f_year') ? ' is-invalid' : '' }}" name="f_year" value="{{ old('f_year')}}" required>
                                            <label for="f_year">年</label>

                                            <select class="{{ $errors->has('f_month') ? 'is-invalid' : '' }}" id="f_month" name="f_month" required>
                                                <option value="">---</option>
                                                @foreach(range(1, 12) as $fMonth)
                                                <option
                                                    value="{{ $fMonth }}"
                                                    {{ old('f_month') == $fMonth ? 'selected' : '' }}
                                                >{{ $fMonth }}</option>
                                                @endforeach
                                            </select>
                                            <label for="f_month">月</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="capital" class="col-form-label col-form-label-sm">資本金</label>
                                        </th>
                                        <td>
                                            <input size="28" type="text" class="form-control form-control-sm col-md-2 d-inline-block {{ $errors->has('capital') ? ' is-invalid' : '' }}" name="capital" value="{{old('capital')}}" placeholder="例）1000万"> 円
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="industry" class="col-form-label col-form-label-sm">業種</label><span class="text-danger ml-1">*</span>
                                        </th>
                                        <td>
                                            <select class="{{ $errors->has('industry') ? 'is-invalid' : '' }}" id="industry" name="industry" required>
                                                <option value="">---</option>
                                                @foreach($industries as $industry)
                                                <option
                                                    value="{{ $industry }}"
                                                    {{ old('industry') == $industry ? 'selected' : '' }}
                                                >{{ $industry }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="description" class="col-form-label col-form-label-sm">事業内容</label><span class="text-danger ml-1">*</span>
                                        </th>
                                        <td>
                                            <textarea type="text"　rows="6" class="form-control form-control-sm {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description"　placeholder="・インターネット広告&#13;&#10;・HP制作&#13;&#10;・コンテンツの企画・運営&#13;&#10;・コンサル事業や職業紹介業" required>{{old('description')}}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="employee_number" class="col-form-label col-form-label-sm">従業員数</label><span class="text-danger ml-1">*</span>
                                        </th>
                                        <td>
                                            <select class="{{ $errors->has('employee_number') ? 'is-invalid' : '' }}" id="employee_number" name="employee_number" required>
                                                <option value="">---</option>
                                                @foreach($employeeNumbers as $employeeNumber)
                                                <option
                                                    value="{{ $employeeNumber }}"
                                                    {{ old('employee_number') == $employeeNumber ? 'selected' : '' }}
                                                >{{ $employeeNumber }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="website" class="col-form-label col-form-label-sm">ホームページ</label>
                                        </th>
                                        <td>
                                            <input type="text" class="form-control form-control-sm {{ $errors->has('website') ? ' is-invalid' : '' }}" name="website" value="{{old('website')}}">
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div><!-- card -->
                    <div class="card mb-5">
                        <div class="card-header">応募設定</div>
                        
                        <div class="card-body">
                            <table class="table table-bordered text-left">
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <label for="" class="col-form-label col-form-label-sm">応募者に通知する電話番号</label><span class="text-danger ml-1">*</span>
                                        </th>
                                        <td>
                                            <div class="form-row m-0">
                                                <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('c_phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="c_phone1" value="{{ old('c_phone1')}}" required>
                                                &nbsp;-&nbsp;
                                                <input size="18"  class="form-control form-control-sm col-md-3 {{ $errors->has('c_phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="c_phone2" value="{{ old('c_phone2') }}" required>
                                                &nbsp;-&nbsp;
                                                <input size="18"  class="form-control form-control-sm col-md-3 {{ $errors->has('c_phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="c_phone3" value="{{ old('c_phone3') }}" required>
                                            </div>
                                        </td>
                                    </tr>                
                                </tbody>
                            </table>
                        </div>
                    </div><!-- card -->
                    <div class="form-group row mb-0">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        登録する
                                    </button>
                                </div>
                            </div>
                </form>
            @endempty
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