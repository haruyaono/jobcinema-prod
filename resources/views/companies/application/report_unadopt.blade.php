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
            <a href="{{ route('enterprise.index.mypage') }}"><span class="bread-text-color-blue">企業ページ</span></a>
        </li>
        <li>
            <a href="{{ route('enterprise.index.application') }}"><span class="bread-text-color-blue">応募一覧</span></a>
        </li>
        <li>
            <a href="{{ route('enterprise.show.application', $apply) }}"><span class="bread-text-color-blue">応募詳細</span></a>
        </li>
        <li>
            <span class="bread-text-color-red">不採用決定</span>
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
                    <p>不採用通知</p>
                </div>

                <div class="applyReportItem mb-5">
                    <div class="border-red border-w2 px-3 pt-2 pb-3">
                        <p class="font20 font-red font-bold mb-2"><i class="fas fa-exclamation-triangle"></i>ご注意</p>
                        <p>応募者が不採用の場合、必ず不採用処理を行って下さい。</p>
                        <p>不採用処理を行うと、必ず不採用通知が送信されます。</p>
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
                    <form action="{{ route('enterprise.update.application.report', [$apply]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="data[Apply][id]" value="{{$apply->id}}">
                        <input type="hidden" name="data[Apply][pushed]" value="SaveUnAdoptStatus" />
                        <table class="table companyTable companyApplyItemTable mb-5">
                            <tr>
                                <th class="d-block w-100">メール本文 <span class="font-red">*</span></th>
                                <td class="d-block w-100">
                                    <textarea name="data[apply][mail]" class="p-1 w-100 {{ $errors->has('data.apply.mail') ? 'is-invalid' : ''}}" rows="10" required>{{ old('data.apply.mail') ?: "この度は、弊社求人にご応募いただきありがとうございます。\n選考の結果、採用はお見送りとなりましたのでお知らせいたします。" }}</textarea>
                                </td>
                            </tr>
                        </table>

                        <div class="applyReportItem">
                            <div class="companyBtnWrap">
                                <button type="submit" class="companyBtn companyBtnGray">不採用を確定する</button>
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
