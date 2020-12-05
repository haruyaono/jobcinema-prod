@extends('layouts.employer_mypage_master')

@section('title', '応募者情報| JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.employer.mypage_header')
@endcomponent
@endsection

<style>
    #js-alert {
        color: red;
        margin-bottom: 10px;
    }
</style>

@section('contents')
<div id="breadcrumb" class="e-mypage-bread only-pc">
    <ol>
        <li>
            <a href="{{ route('enterprise.index.mypage') }}"><span class="bread-text-color-blue">企業ページ</span></a>
        </li>
        <li>
            <a href="{{ route('enterprise.index.application') }}"><span class="bread-text-color-blue">応募一覧</span></a>
        </li>
        <li>
            <a href="{{ route('enterprise.show.application', $apply) }}"><span class="bread-text-color-blue">応募詳細</span></a>
        </li>
        <li>
            <span class="bread-text-color-red">採用決定</span>
        </li>
    </ol>
</div>
<div class="main-wrap">
    <section class="main-section companyApplySection">
        <div class="inner">
            <div class="pad">
                @if (Session::has('flash_message_success'))
                <div class="alert alert-success mt-3">
                    {!! nl2br(htmlspecialchars(Session::get('flash_message_success'))) !!}
                </div>
                @endif
                @if (Session::has('flash_message_danger'))
                <div class="alert alert-danger mt-3">
                    {!! nl2br(htmlspecialchars(Session::get('flash_message_danger'))) !!}
                </div>
                @endif
                <div class="applyReportTtl font-blue font24 font-bold text-center mb-5">
                    <p>この応募者の採用を決定します</p>
                </div>
                <div class="applyReportItem">
                    <table class="table companyTable companyApplyItemTable">
                        <tr>
                            <th>名前</th>
                            <td>
                                {{ $apply->detail->full_name }}
                            </td>
                        </tr>
                        <tr>
                            <th>性別・年齢</th>
                            <td>
                                {{ $apply->detail->age }}歳　{{ $apply->detail->gender }}
                            </td>
                        </tr>
                        <tr>
                            <th>応募日</th>
                            <td>
                                {{ $apply->getCreatedAtTransform('Y年m月d日')}}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="applyReportItem my-5">
                    <div class="text-center">
                        <p class="font22 font-yellow font-bold">
                            <span>採用成果報酬額 : {{ $apply->custom_recruitment_fee }}</span>
                        </p>
                        <p class="font16 font-bold">※応募時点で設定されていた金額となります。</p>
                    </div>
                </div>

                <div class="applyReportItem mb-5">
                    <div class="border-red border-w2 px-3 pt-2 pb-3">
                        <p class="font20 font-red font-bold mb-2"><i class="fas fa-exclamation-triangle"></i>ご注意</p>
                        <p>保証期間内に辞職された場合は必ずご連絡下さい。</p>
                        <p>保証期間内に辞職の連絡がなかった場合は、満額のご請求になりますのでご注意下さい。</p>
                    </div>
                </div>

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

                <div class="applyReportItem mb-5">
                    <form action="{{route('enterprise.update.application.report', [$apply])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="data[Apply][id]" value="{{$apply->id}}">
                        <input type="hidden" name="data[Apply][pushed]" value="SaveAdoptStatus" />
                        <table class="table companyTable companyApplyItemTable mb-5">
                            <tr>
                                <th>初出社日</th>
                                <td>
                                    <div id="js-alert"></div>
                                    <input id="year" name="data[apply][year]" pattern="[0-9]{1,4}" onchange="inputCheck(event)" class="{{ $errors->has('data.apply.year') ? 'is-invalid' : ''}}" type="text" placeholder="西暦" maxlength="4" value="{{ old('data.apply.year') }}">
                                    <span>年</span>
                                    <input id="month" name="data[apply][month]" pattern="[0-9]{1,2}" type="text" onchange="inputCheck(event)" class="{{ $errors->has('data.apply.month') ? 'is-invalid' : ''}}" maxlength="2" value="{{old('data.apply.month')}}" placeholder="04">
                                    <span>月</span>
                                    <input id="date" name="data[apply][date]" pattern="[0-9]{1,2}" type="text" onchange="inputCheck(event)" class="{{ $errors->has('data.apply.date') ? 'is-invalid' : ''}}" maxlength="2" value="{{old('data.apply.date')}}" placeholder="01">
                                    <span>日</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-row align-items-center mb-2 px-2">
                                        <input type="checkbox" name="data[is_attendance]" value="1" @if(old('data.is_attendance')){{ 'checked' }}@endif id="firstVisitCheck" class="mr-1"><label for="firstVisitCheck">初出社日が未定の場合はこちらをチェックして理由をご記入下さい</label>
                                    </div>
                                    <div class="form-row px-2">
                                        <textarea name="data[apply][e_nofirst_attendance]" class="w-100 {{ $errors->has('data.apply.e_nofirst_attendance') ? 'is-invalid' : ''}}" rows="10">{{ old('data.apply.e_nofirst_attendance') }}</textarea>
                                    </div>

                                </td>
                            </tr>
                        </table>
                        <div class="form-row align-items-center mb-2 px-2 justify-content-center">
                            <input type="checkbox" name="data[is_sendable]" value="1" @if(old('data.is_sendable')){{ 'checked' }}@endif id="SendCheck" class="mr-1"><label for="SendCheck">応募者に採用通知メッセージを送る</label>
                        </div>
                        <div class="applyReportItem">
                            <div class="companyBtnWrap">
                                <button type="submit" class="companyBtn companyBtnOrange">採用を確定する</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-5">
                    <a class="btn back-btn" href="#" onclick="javascript:window.history.back(-1);return false;"><i class="fas fa-reply mr-3"></i>前に戻る</a>
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

@section('js')
<script defer>
    function inputCheck(event) {
        const name = event.target.name;
        const value = event.target.value;

        if (value.match(/[0-9]+/g) != value) {
            document.getElementById('js-alert').innerHTML = '数値を入力してください。';
        } else {
            document.getElementById('js-alert').innerHTML = '';
        }
    }
</script>
@endsection
