@extends('layouts.employer_mypage_master')

@section('title', '応募者情報| JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.employer.mypage_header')
@endcomponent
@endsection

@section('contents')
<div id="breadcrumb" class="e-mypage-bread only-pc">
    <ol>
        <li>
            <a href="{{ route('index.company.mypage') }}"><span class="bread-text-color-blue">企業ページ</span></a>
        </li>
        <li>
            <a href="{{ route('index.company.application') }}"><span class="bread-text-color-blue">応募一覧</span></a>
        </li>
        <li>
            <a href="{{ route('show.company.application', $apply) }}"><span class="bread-text-color-blue">応募詳細</span></a>
        </li>
        <li>
            <span class="bread-text-color-red">辞退処理</span>
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
                <div class="applyReportTtl font24 font-bold mb-5">
                    <p>辞退処理</p>
                </div>

                <div class="applyReportItem mb-5">
                    <div class="border-red border-w2 px-3 pt-2 pb-3">
                        <p class="font20 font-red font-bold mb-2"><i class="fas fa-exclamation-triangle"></i>ご注意</p>
                        <p>辞退の場合、必ず辞退処理を行って下さい。</p>
                        <p>辞退処理を行うと、応募者に必ず辞退通知が送信されます。</p>
                        <p>既に応募者に通知済みの可能性がございますので、二重通知になった場合のお詫び文が自動添付されます。</p>
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
                    <form action="{{route('update.company.application.report', [$apply])}}" method="POST" name="ReportDeclineForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="data[Apply][id]" value="{{$apply->id}}">
                        <input type="hidden" name="data[Apply][pushed]" value="SaveDeclineStatus" />
                        <table class="table companyTable companyApplyItemTable mb-5">
                            <tr>
                                <th>理由区分 <span class="font-red">*</span></th>
                                <td>
                                    <select name="data[decline][flag]" id="ReportDecline" onchange="change()" class="p-2" required>
                                        <option value="0" @if(old('data.decline.flag')=='0' ){{ 'selected' }}@endif>理由を選択して下さい</option>
                                        <option value="応募者から辞退" @if(old('data.decline.flag')=='応募者から辞退' ){{ 'selected' }}@endif>応募者から辞退</option>
                                        <option value="応募者と連絡が取れない" @if(old('data.decline.flag')=='応募者と連絡が取れない' ){{ 'selected' }}@endif>応募者と連絡が取れない</option>
                                        <option value="採用の定員に達した" @if(old('data.decline.flag')=='採用の定員に達した' ){{ 'selected' }}@endif>採用の定員に達した</option>
                                        <option value="その他" @if(old('data.decline.flag')=='その他' ){{ 'selected' }}@endif>その他</option>
                                    </select>
                                    <div id="OtherArea" class="d-none">
                                        <p class="mt-3 mb-1">その他の理由を入力して下さい <span class="font-red">*</span></p>
                                        <textarea id="OtherTextArea" name="data[decline][text]" class="p-1 w-100 {{ $errors->has('data.decline.text') ? 'is-invalid' : ''}}" rows="10">{{ old('data.decline.text') }}</textarea>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <div class="applyReportItem">
                            <div class="companyBtnWrap">
                                <button type="submit" class="companyBtn companyBtnCyan">辞退処理を確定する</button>
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
    let dSelect = document.ReportDeclineForm.ReportDecline,
        otherTextArea = document.getElementById('OtherTextArea'),
        other = document.getElementById('OtherArea');

    if (dSelect.value == 'その他') {
        other.classList.remove('d-none');
        other.classList.add('d-block');
    } else {
        other.classList.add('d-none');
        other.classList.remove('d-block');
        otherTextArea.value = '';
    }

    function change(event) {
        dSelect = document.ReportDeclineForm.ReportDecline;
        otherTextArea = document.getElementById('OtherTextArea');
        other = document.getElementById('OtherArea');

        if (dSelect.value == 'その他') {
            other.classList.remove('d-none');
            other.classList.add('d-block');
        } else {
            other.classList.add('d-none');
            other.classList.remove('d-block');
            otherTextArea.value = '';
        }
    }
</script>
@endsection
