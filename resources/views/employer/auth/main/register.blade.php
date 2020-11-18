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
                            <h2 class="txt-h2 d-inline-block mb-3">企業本登録ページ</h2>
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
                                                            <input type="text" size="28" class="form-control form-control-sm mr-2{{ $errors->has('company_form.employer.last_name') ? ' is-invalid' : '' }}" name="company_form[employer][last_name]" value="{{ old('company_form.employer.last_name') ?: $employer->last_name }}" required>
                                                            <input type="text" size="28" class="form-control form-control-sm {{ $errors->has('company_form.employer.first_name') ? ' is-invalid' : '' }}" name="company_form[employer][first_name]" value="{{ old('company_form.employer.first_name') ?: $employer->first_name }}" required>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <label for="" class="col-form-label col-form-label-sm">フリガナ</label><span class="text-danger ml-1">*</span>
                                                    </th>
                                                    <td>
                                                        <div class="form-row">
                                                            <input type="text" size="28" class="form-control form-control-sm mr-2 {{ $errors->has('company_form.employer.last_name_katakana') ? ' is-invalid' : '' }}" name="company_form[employer][last_name_katakana]" value="{{ old('company_form.employer.last_name_katakana') }}" required>
                                                            <input type="text" size="28" class="form-control form-control-sm {{ $errors->has('company_form.employer.first_name_katakana') ? ' is-invalid' : '' }}" name="company_form[employer][first_name_katakana]" value="{{ old('company_form.employer.first_name_katakana') }}" required>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <label for="" class="col-form-label col-form-label-sm">ご担当者様電話番号</label><span class="text-danger ml-1">*</span>
                                                    </th>
                                                    <td>
                                                        <div class="form-row m-0">
                                                            <input size="18" class="form-control form-control-sm col-md-2 {{ $errors->has('company_form.employer.phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="company_form[employer][phone1]" value="{{ old('company_form.employer.phone1') ?: $employer->phone1 }}" required>
                                                            &nbsp;-&nbsp;
                                                            <input size="18" class="form-control form-control-sm col-md-2 {{ $errors->has('company_form.employer.phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="company_form[employer][phone2]" value="{{ old('company_form.employer.phone2') ?: $employer->phone2 }}" required>
                                                            &nbsp;-&nbsp;
                                                            <input size="18" class="form-control form-control-sm col-md-2 {{ $errors->has('company_form.employer.phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="company_form[employer][phone3]" value="{{ old('company_form.employer.phone3') ?: $employer->phone3}}" required>
                                                        </div>
                                                        <p class="mt-2">※運営との連絡用お電話番号です</p>
                                                        <p>※求職者には非公開</p>

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
                                                        <input size="65" type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.cname') ? ' is-invalid' : '' }}" name="company_form[company][cname]" value="{{ old('company_form.company.cname') ?: $employer->company->cname }}" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <label for="cname_katakana" class="col-form-label col-form-label-sm">会社名(フリガナ)</label><span class="text-danger ml-1">*</span>
                                                    </th>
                                                    <td>
                                                        <input size="65" type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.cname_katakana') ? ' is-invalid' : '' }}" name="company_form[company][cname_katakana]" value="{{ old('company_form.company.cname_katakana') }}" required>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">
                                                        <label for="" class="ol-form-label col-form-label-sm">本社住所</label><span class="text-danger ml-1">*</span>
                                                    </th>
                                                    <td>
                                                        <div class="form-row m-0">
                                                            〒 <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('company_form.company.postcode01') ? 'is-invalid' : '' }}" type="text" name="company_form[company][postcode01]" maxlength="3" value="{{ old('company_form.company.postcode01') }}" required>&nbsp;-&nbsp;<input size="28" class="form-control form-control-sm col-md-4 {{ $errors->has('company_form.company.postcode02') ? 'is-invalid' : '' }}" type="text" name="company_form[company][postcode02]" maxlength="4" value="{{ old('company_form.company.postcode02') }}" onKeyUp="AjaxZip3.zip2addr('company_form[company][postcode01]','company_form[company][postcode02]','company_form[company][prefecture]','company_form[company][address]');" required>
                                                        </div>
                                                        <input size="28" class="form-control form-control-sm mt-3 {{ $errors->has('company_form.company.prefecture') ? 'is-invalid' : '' }}" type="text" name="company_form[company][prefecture]" value="{{ old('company_form.company.prefecture') }}" placeholder="例）北海道" required>
                                                        <input size="65" class="form-control form-control-sm mt-3 {{ $errors->has('company_form.company.address') ? 'is-invalid' : '' }}" type="text" name="company_form[company][address]" value="{{ old('company_form.company.address') }}" 　placeholder="例）釧路市 〇〇西 2-24-12" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <label for="ceo" class="col-form-label col-form-label-sm">代表者様</label>
                                                    </th>
                                                    <td>
                                                        <input size="28" type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.ceo') ? ' is-invalid' : '' }}" name="company_form[company][ceo]" value="{{ old('company_form.company.ceo') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <label for="" class="col-form-label col-form-label-sm">設立</label><span class="text-danger ml-1">*</span>
                                                    </th>
                                                    <td>
                                                        <label for="f_year">西暦</label>
                                                        <input type="text" maxlength="4" size="18" class="form-control form-control-sm col-md-2 d-inline-block {{ $errors->has('company_form.company.f_year') ? ' is-invalid' : '' }}" name="company_form[company][f_year]" value="{{ old('company_form.company.f_year') }}" required>
                                                        <label for="f_year">年</label>

                                                        <select class="{{ $errors->has('company_form.company.f_month') ? 'is-invalid' : '' }}" id="f_month" name="company_form[company][f_month]" required>
                                                            <option value="0">---</option>
                                                            @foreach(range(1, 12) as $fMonth)
                                                            <option value="{{ $fMonth }}" {{ old('company_form.company.f_month') == $fMonth ? 'selected' : '' }}>{{ $fMonth }}</option>
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
                                                        <input size="28" type="text" class="form-control form-control-sm col-md-2 d-inline-block {{ $errors->has('company_form.company.capital') ? ' is-invalid' : '' }}" name="company_form[company][capital]" value="{{ old('company_form.company.capital') }}" placeholder="例）1000万"> 円
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <label for="industry" class="col-form-label col-form-label-sm">業種</label><span class="text-danger ml-1">*</span>
                                                    </th>
                                                    <td>
                                                        <select class="{{ $errors->has('company_form.company.industry') ? 'is-invalid' : '' }}" id="industry" name="company_form[company][industry]" required>
                                                            <option value="0">---</option>
                                                            @foreach($industries as $industry)
                                                            <option value="{{ $industry }}" {{ old('company_form.company.industry') == $industry ? 'selected' : '' }}>{{ $industry }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <label for="description" class="col-form-label col-form-label-sm">事業内容</label><span class="text-danger ml-1">*</span>
                                                    </th>
                                                    <td>
                                                        <textarea type="text" rows="6" class="form-control form-control-sm {{ $errors->has('company_form.company.description') ? ' is-invalid' : '' }}" name="company_form[company][description]" 　placeholder="例）&#13;&#10;・インターネット広告&#13;&#10;・HP制作&#13;&#10;・コンテンツの企画・運営&#13;&#10;・コンサル事業や職業紹介業" required>{{ old('company_form.company.description') }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <label for="employee_number" class="col-form-label col-form-label-sm">従業員数</label><span class="text-danger ml-1">*</span>
                                                    </th>
                                                    <td>
                                                        <select class="{{ $errors->has('company_form.company.employee_number') ? 'is-invalid' : '' }}" id="employee_number" name="company_form[company][employee_number]" required>
                                                            <option value="0">---</option>
                                                            @foreach($employeeNumbers as $employeeNumber)
                                                            <option value="{{ $employeeNumber }}" {{ old('company_form.company.employee_number') == $employeeNumber ? 'selected' : '' }}>{{ $employeeNumber }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <label for="website" class="col-form-label col-form-label-sm">ホームページ</label>
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm {{ $errors->has('company_form.company.website') ? ' is-invalid' : '' }}" name="company_form[company][website]" value="{{ old('company_form.company.website') }}">
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
                                                        <label for="" class="col-form-label col-form-label-sm">求職者が連絡する電話番号</label><span class="text-danger ml-1">*</span>
                                                    </th>
                                                    <td>
                                                        <div class="form-row mb-2 align-items-center">
                                                            <input type="checkbox" name="samePhone" value="0" id="samePhone" onchange="incopy(this.form)" /><label for="samePhone">ご担当者様お電話番号と同じ</label>
                                                        </div>
                                                        <div class="form-row m-0">
                                                            <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('company_form.company.phone1') ? 'is-invalid' : '' }}" maxlength="5" type="text" name="company_form[company][phone1]" value="{{ old('company_form.company.phone1') }}" required>
                                                            &nbsp;-&nbsp;
                                                            <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('company_form.company.phone2') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="company_form[company][phone2]" value="{{ old('company_form.company.phone2') }}" required>
                                                            &nbsp;-&nbsp;
                                                            <input size="18" class="form-control form-control-sm col-md-3 {{ $errors->has('company_form.company.phone3') ? 'is-invalid' : '' }}" maxlength="4" type="text" name="company_form[company][phone3]" value="{{ old('company_form.company.phone3') }}" required>
                                                        </div>
                                                        <p class="mt-2">※求職者に公開されます</p>
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
            </div> <!-- pad -->
        </div> <!-- inner -->
    </section>
</div> <!-- main-wrap -->
@endsection

@section('footer')
@component('components.employer.form_footer')
@endcomponent
@endsection

@section('js')
<script type="text/javascript">
    function incopy(frmObj) {
        let checked = frmObj.samePhone.checked;
        const count = 3;
        if (checked) {
            for (let i = 1; i < count + 1; i++) {
                frmObj.elements["company_form[company][phone" + i + "]"].value = frmObj.elements["company_form[employer][phone" + i + "]"].value;
            }
        } else {
            for (let i = 1; i < count + 1; i++) {
                frmObj.elements["company_form[company][phone" + i + "]"].value = '';
            }
        }
    }
</script>
@endsection
