@extends('layouts.employer_mypage_master')

@section('title', '企業データ | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
  @component('components.employer.mypage_header')
  @endcomponent
@endsection

@section('contents')
<!-- パンくず -->
<div id="breadcrumb" class="e-mypage-bread only-pc">
<ol>
  <li>
      <a href="/company/mypage"><span class="bread-text-color-blue">企業ページ</span></a>
  </li>
  <li>
   <span class="bread-text-color-red">企業データ</span>
  </li>
</ol>
</div>
<div class="main-wrap">
<section class="main-section emp-main-register-section">
<div class="inner">
<div class="pad">
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
    <div class="row justify-content-center">
        <form action="{{ route('companies.store') }}" method="POST" class="text-left col-md-12 p-0">
        @csrf
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">企業データ</div>
                
                <div class="card-body">
                    <table class="table table-bordered text-left">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="cname" class="col-form-label col-form-label-sm">会社名</label><span class="text-danger ml-1">*</span>
                                </th>
                                <td>
                                    <input type="text" class="form-control form-control-sm {{ $errors->has('cname') ? ' is-invalid' : '' }}" name="cname" value="{{old('cname')}}@if(!old('cname')){{ Auth::guard('employer')->user()->company->cname }}@endif" required>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="cname_katakana" class="col-form-label col-form-label-sm">会社名(フリガナ)</label><span class="text-danger ml-1">*</span>
                                </th>
                                <td>
                                    <input type="text" class="form-control form-control-sm {{ $errors->has('cname_katakana') ? ' is-invalid' : '' }}" name="cname_katakana" value="{{ old('cname_katakana') }}@if(!old('cname_katakana')){{ Auth::guard('employer')->user()->company->cname_katakana }}@endif" required>
                                </td>
                            </tr>
                            
                            <tr>
                                <th scope="row">
                                    <label for="" class="ol-form-label col-form-label-sm">本社住所</label><span class="text-danger ml-1">*</span>
                                </th>
                                <td>
                                    <div class="form-row m-0">
                                    〒 <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('zip31') ? 'is-invalid' : '' }}" type="text" name="zip31" maxlength="3" value="{{old('zip31') }}@if(!old('zip31')){{ $postcode1 }}@endif" required>&nbsp;-&nbsp;<input size="28" class="form-control form-control-sm col-md-4 {{ $errors->has('zip32') ? 'is-invalid' : '' }}" type="text" name="zip32" maxlength="4" value="{{old('zip32')}}@if(!old('zip32')){{$postcode2 }}@endif" onKeyUp="AjaxZip3.zip2addr('zip31','zip32','pref31','addr31','addr31');" required>
                                    </div>
                                    <input size="28" class="form-control form-control-sm mt-3 {{ $errors->has('pref31') ? 'is-invalid' : '' }}" type="text" name="pref31" value="{{ old('pref31') }}@if(!old('pref31')){{ Auth::guard('employer')->user()->company->prefecture }}@endif" required>
                                    <input size="65" class="form-control form-control-sm mt-3 {{ $errors->has('addr31') ? 'is-invalid' : '' }}" type="text" name="addr31" value="{{ old('addr31') }}@if(!old('addr31')){{ Auth::guard('employer')->user()->company->address }}@endif" required>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="ceo" class="col-form-label col-form-label-sm">代表者様</label>
                                </th>
                                <td>
                                    <input type="text" class="form-control form-control-sm {{ $errors->has('ceo') ? ' is-invalid' : '' }}" name="ceo" value="{{old('ceo')}}@if(!old('ceo')){{ Auth::guard('employer')->user()->company->ceo }}@endif">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="" class="col-form-label col-form-label-sm">設立</label><span class="text-danger ml-1">*</span>
                                </th>
                                <td>
                                    <label for="f_year">西暦</label>
                                    <input size="18" type="text" maxlength="4" class="form-control form-control-sm {{ $errors->has('f_year') ? ' is-invalid' : '' }} col-md-2 d-inline-block" name="f_year" value="{{ old('f_year')}}@if(!old('f_year')){{ $foundation1 }}@endif" required>
                                    <label for="f_year">年</label>

                                    <select class="{{ $errors->has('f_month') ? 'is-invalid' : '' }}" id="f_month" name="f_month" required>
                                        <option value="">---</option>
                                        @foreach(range(1, 12) as $fMonth)
                                        <option
                                            value="{{ $fMonth }}"
                                            {{ old('f_month') == $fMonth || $fMonth == $foundation2 ? 'selected' : '' }}
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
                                    <input size="28"  type="text" class="form-control form-control-sm ol-md-2 d-inline-block {{ $errors->has('capital') ? ' is-invalid' : '' }}" name="capital" value="{{old('capital')}}@if(!old('capital')){{ Auth::guard('employer')->user()->company->capital }}@endif" placeholder="例）1000万">円
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
                                            {{ old('industry') == $industry || $industry == Auth::guard('employer')->user()->company->industry ? 'selected' : '' }}
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
                                    <textarea rows="6" type="text" class="form-control form-control-sm {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required>{{old('description')}}@if(!old('description')){{ Auth::guard('employer')->user()->company->description }}@endif</textarea>
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
                                            {{ old('employee_number') == $employeeNumber || $employeeNumber == Auth::guard('employer')->user()->company->employee_number ? 'selected' : '' }}
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
                                    <input type="text" class="form-control form-control-sm {{ $errors->has('website') ? ' is-invalid' : '' }}" name="website" value="{{old('website')}}@if(!old('website')){{ Auth::guard('employer')->user()->company->website }}@endif">
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card">
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
                                        <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('c_phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="c_phone1" value="{{ old('c_phone1')}}@if(!old('c_phone1')){{ Auth::guard('employer')->user()->company->phone1 }}@endif" required>
                                        &nbsp;-&nbsp;
                                        <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('c_phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="c_phone2" value="{{ old('c_phone2') }}@if(!old('c_phone2')){{ Auth::guard('employer')->user()->company->phone2 }}@endif" required>
                                        &nbsp;-&nbsp;
                                        <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('c_phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="c_phone3" value="{{ old('c_phone3') }}@if(!old('c_phone3')){{ Auth::guard('employer')->user()->company->phone3 }}@endif" required>
                                    </div>
                                </td>
                            </tr>                
                        </tbody>
                    </table>
                </div>
            </div><!-- card -->
        </div>

        <div class="form-group mt-3 text-center">
            <button class="btn btn-success" type="submit">更新</button>
        </div>
        </form>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">企業ロゴ</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            @if(empty(Auth::guard('employer')->user()->company->logo))
                            <img class="company-logo-image" src="{{ asset('uploads/images/no-image.gif') }}" alt="">
                            @elseif(App::environment('production'))
                            <img class="company-logo-image" src="https://s3.job-cinema.com/{{ Auth::guard('employer')->user()->company->logo }}" 
                            @else
                            <img class="company-logo-image" src="{{ asset('/')}}{{ Auth::guard('employer')->user()->company->logo }}" alt="">
                            @endif
                            {!! Form::open(['url' => '/company/logo/delete', 'method' => 'post', 'class' => 'text-right']) !!}
                            {{ method_field('DELETE') }}
                                <button class="mt-1">削除</button>
                            {!! Form::close() !!}   
                        </div>
                        <div class="col-md-7 mt-3">
                            <form action="{{route('companies.logo')}}" method="post" enctype="multipart/form-data" class="mt-3">
                            @csrf
                                <input type="file" class="form-control" name="logo" accept="image/*">
                                <button class="btn btn-success mt-3" type="submit">更新</button>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a class="btn back-btn" href="#" onclick="javascript:window.history.back(-1);return false;"><i class="fas fa-reply mr-3"></i>前に戻る</a>
        </div>
        
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
