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
            <a href="{{ route('enterprise.index.mypage') }}"><span class="bread-text-color-blue">企業ページ</span></a>
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
                    <form action="{{ route('enterprise.update.profile') }}" method="POST" class="text-left col-md-12 p-0 file-apload-form">
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
                                                    <input type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.cname') ? ' is-invalid' : '' }}" name="company_form[company][cname]" value="{{ old('company_form.company.cname') ?: $employer->company->cname }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="cname_katakana" class="col-form-label col-form-label-sm">会社名(フリガナ)</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.cname_katakana') ? ' is-invalid' : '' }}" name="company_form[company][cname_katakana]" value="{{ old('company_form.company.cname_katakana') ?: $employer->company->cname_katakana }}" required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">
                                                    <label for="" class="ol-form-label col-form-label-sm">本社住所</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <div class="form-row m-0">
                                                        〒 <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('company_form.company.postcode01') ? 'is-invalid' : '' }}" type="text" name="company_form[company][postcode01]" maxlength="3" value="{{ old('company_form.company.postcode01') ?: array_key_exists(0, $postcode) ? $postcode[0] : '' }}" required>&nbsp;-&nbsp;<input size="28" class="form-control form-control-sm col-md-4 {{ $errors->has('company_form.company.postcode02') ? 'is-invalid' : '' }}" type="text" name="company_form[company][postcode02]" maxlength="4" value="{{ old('company_form.company.postcode02') ?: array_key_exists(1, $postcode) ? $postcode[1] : '' }}" onKeyUp="AjaxZip3.zip2addr('company_form[company][postcode01]','company_form[company][postcode02]','company_form[company][prefecture]','company_form[company][address]');" required>
                                                    </div>
                                                    <input size="28" class="form-control form-control-sm mt-3 {{ $errors->has('company_form.company.prefecture') ? 'is-invalid' : '' }}" type="text" name="company_form[company][prefecture]" value="{{ old('company_form.company.prefecture') ?: $employer->company->prefecture }}" required>
                                                    <input size="65" class="form-control form-control-sm mt-3 {{ $errors->has('company_form.company.address') ? 'is-invalid' : '' }}" type="text" name="company_form[company][address]" value="{{ old('company_form.company.address') ?: $employer->company->address }}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="ceo" class="col-form-label col-form-label-sm">代表者様</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.ceo') ? ' is-invalid' : '' }}" name="company_form[company][ceo]" value="{{ old('company_form.company.ceo') ?: $employer->company->ceo }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="" class="col-form-label col-form-label-sm">設立</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <label for="f_year">西暦</label>
                                                    <input size="18" type="text" maxlength="4" class="form-control form-control-sm {{ $errors->has('company_form.company.f_year') ? ' is-invalid' : '' }} col-md-2 d-inline-block" name="company_form[company][f_year]" value="{{ old('company_form.company.f_year') ?: array_key_exists(0, $foundation) ? $foundation[0] : '' }}" required>
                                                    <label for="f_year">年</label>

                                                    <select class="{{ $errors->has('company_form.company.f_month') ? 'is-invalid' : '' }}" id="f_month" name="company_form[company][f_month]" required>
                                                        <option value="0">---</option>
                                                        @foreach(range(1, 12) as $fMonth)
                                                        <option value="{{ $fMonth }}" {{ old('company_form.company.f_month') == $fMonth ? 'selected' : $fMonth == array_key_exists(1, $foundation) ? $foundation[1] : '' ? 'selected' : '' }}>{{ $fMonth }}</option>
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
                                                    <input size="28" type="text" class="form-control form-control-sm ol-md-2 d-inline-block {{ $errors->has('company_form.company.capital') ? ' is-invalid' : '' }}" name="company_form[company][capital]" value="{{ old('company_form.company.capital') ?: $employer->company->capital }}" placeholder="例）1000万">円
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="industry" class="col-form-label col-form-label-sm">業種</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <select class="{{ $errors->has('company_form.company.industry') ? 'is-invalid' : '' }}" id="industry" name="company_form[company][industry]" required>
                                                        <option value="">---</option>
                                                        @foreach($industries as $industry)
                                                        <option value="{{ $industry }}" {{ old('company_form.company.industry') == $industry || $industry == $employer->company->industry ? 'selected' : '' }}>{{ $industry }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="description" class="col-form-label col-form-label-sm">事業内容</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <textarea rows="6" type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.description') ? ' is-invalid' : '' }}" name="company_form[company][description]" required>{{ old('company_form.company.description') ?: $employer->company->description }}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="employee_number" class="col-form-label col-form-label-sm">従業員数</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <select class="{{ $errors->has('company_form.company.employee_number') ? 'is-invalid' : '' }}" id="employee_number" name="company_form[company][employee_number]" required>
                                                        <option value="">---</option>
                                                        @foreach($employeeNumbers as $employeeNumber)
                                                        <option value="{{ $employeeNumber }}" {{ old('company_form.company.employee_number') == $employeeNumber || $employeeNumber == $employer->company->employee_number ? 'selected' : '' }}>{{ $employeeNumber }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="website" class="col-form-label col-form-label-sm">ホームページ</label>
                                                </th>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.website') ? ' is-invalid' : '' }}" name="company_form[company][website]" value="{{ old('company_form.company.website') ?: $employer->company->website }}">
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
                                                    <label for="" class="col-form-label col-form-label-sm">求職者が連絡する電話番号</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <div class="form-row m-0">
                                                        <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('company_form.company.phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="company_form[company][phone1]" value="{{ old('company_form.company.phone1') ?: $employer->company->phone1 }}" required>
                                                        &nbsp;-&nbsp;
                                                        <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('company_form.company.phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="company_form[company][phone2]" value="{{ old('company_form.company.phone2') ?: $employer->company->phone2 }}" required>
                                                        &nbsp;-&nbsp;
                                                        <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('company_form.company.phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="company_form[company][phone3]" value="{{ old('company_form.company.phone3') ?: $employer->company->phone3 }}" required>
                                                    </div>
                                                    <p class="mt-2">※求職者に公開されます</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- card -->
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="card">
                                <div class="card-header">お支払い設定</div>
                                <div class="card-body">
                                    <table class="table table-bordered text-left">
                                        <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <label for="" class="col-form-label col-form-label-sm">銀行名</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <input size="28" type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.bank_name') ? ' is-invalid' : '' }}" name="company_form[company][bank_name]" value="{{ old('company_form.company.bank_name') ?: $employer->company->bank_name }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="" class="col-form-label col-form-label-sm">支店名</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <input size="28" type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.branch_name') ? ' is-invalid' : '' }}" name="company_form[company][branch_name]" value="{{ old('company_form.company.branch_name') ?: $employer->company->branch_name }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="" class="col-form-label col-form-label-sm">口座タイプ</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <select name="company_form[company][account_type]">
                                                        <option value="普通" @if(old('company_form.company.account_type') == "普通" || $employer->company->account_type == "普通") selected @endif>普通</option>
                                                        <option value="当座" @if(old('company_form.company.account_type') == "当座" || $employer->company->account_type == "当座") selected @endif>当座</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label for="" class="col-form-label col-form-label-sm">口座番号</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <input size="28" type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.account_number') ? ' is-invalid' : '' }}" name="company_form[company][account_number]" value="{{ old('company_form.company.account_number') ?: $employer->company->account_number }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <label class="col-form-label col-form-label-sm">振込人名義（カタカナ）</label><span class="text-danger ml-1">*</span>
                                                </th>
                                                <td>
                                                    <input size="28" type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.transfer_person_name') ? ' is-invalid' : '' }}" name="company_form[company][transfer_person_name]" value="{{ old('company_form.company.transfer_person_name') ?: $employer->company->transfer_person_name }}">
                                                    <p class="mt-2">※成果報酬お振込の確認に使用します</p>
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
                    <div class="text-center mt-5">
                        <a class="btn back-btn" href="#" onclick="javascript:window.history.back(-1);return false;"><i class="fas fa-reply mr-3"></i>前に戻る</a>
                    </div>

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
