@extends('layouts.master')

@section('title', '応募管理 | JOB CiNEMA')
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
            応募管理
        </li>
    </ol>
</div>

<div class="main-wrap">
    <section class="main-section">
        <div class="inner">
            <div class="pad">
                <h2 class="txt-h2 mb-3">応募管理</h2>
                <p class="mb-4">応募データは応募から180日間表示されます。</p>
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
                <div class="seeker-jobapp-list">
                    @if(!$applies->isEmpty())
                    @foreach($applies as $apply)
                    @if($apply->e_recruit_status !== 0)
                    <div class="status_e_to_seeker">
                        採用通知： <span class="e-status e-status_{{ $apply->e_recruit_status }}">{{ config("const.RECRUITMENT_STATUS.{$apply->e_recruit_status}", "未定義") }}</span>
                    </div>
                    @endif
                    <div class="seeker-jobapp-item">

                        <div class="jobapp-item-header">
                            <div class="header-status">
                                {{ config("const.RECRUITMENT_STATUS.{$apply->s_recruit_status}", "未定義") }}
                            </div>
                            <div class="header-date">
                                応募日：{{ $apply->getCreatedAtTransform('Y-m-d') }}
                            </div>
                            @if($apply->congrats_status === 1)
                            <div class="header-money">
                                この企業に採用されるとお祝い金<span class="ml-2">{{ $apply->congrats_amount }}<span>
                            </div>
                            @endif
                        </div>
                        <div class="jobapp-item-middle">
                            <div class="jobapp-item-img only-pc">
                                @if($apply->jobitem->job_img_1)
                                <img src="{{ config('app.s3_url') . config('jobcinema.jobitem_image_dir') . $apply->jobitem->job_img_1 }}" alt="{{ $apply->company->cname }}">
                                @else
                                <img src="{{ asset('img/common/no-image.gif') }}">
                                @endif
                            </div>
                            <div class="jobapp-item-text">
                                <table>
                                    <tr>
                                        <th>応募企業</th>
                                        <td>{{ $apply->company->cname }}</td>
                                    </tr>
                                    <tr>
                                        <th>勤務先</th>
                                        <td>{{ $apply->jobitem->job_office }}</td>
                                    </tr>
                                    <tr>
                                        <th>雇用形態</th>
                                        <td>{{ $apply->jobitem->categories()->wherePivot('ancestor_slug', 'status')->first() !== null ? $apply->jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>職種</th>
                                        <td>{{ $apply->jobitem->job_type }}</td>
                                    </tr>
                                    <tr>
                                        <th>住所</th>
                                        <td>{{ str_limit($apply->jobitem->job_office_address, $limit = 16, $end = '...') }}</td>
                                    </tr>
                                    <tr>
                                        <th>電話番号</th>
                                        <td>
                                            {{ $apply->company->phone1}}-{{$apply->company->phone2}}-{{$apply->company->phone3 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>採用担当</th>
                                        <td>
                                            {{ $apply->jobitem->employer->last_name }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="jobapp-item-btn">
                                <p class="mb-3"><a href="{{ route('show.front.job_sheet.detail', [$apply->jobitem]) }}">詳細を見る</a></p>
                                @if($apply->s_recruit_status === 0 )
                                <p><a href="{{ route('seeker.show.job', [$apply]) }}" class="btn btn-yellow">結果を報告</a></p>
                                <p>
                                    <a id="SaveReportDeclineCancel" href="javascript:void(0)" class="btn btn-secondary jobapp-cancel-btn">選考を辞退</a>
                                    <form id="seeker-apply-report-decline-form" action="{{ route('seeker.update.report', [$apply]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="data[Apply][id]" value="{{ $apply->id }}">
                                        <input type="hidden" name="data[Apply][pushed]" value="SaveReportDeclineStatus" />
                                    </form>
                                </p>
                                @else
                                <p><span class="btn btn-outline-yellow">報告済み</span></p>
                                @if($apply->s_recruit_status === 1 )
                                @if($apply->s_first_attendance === null)
                                <p><a href="{{ route('seeker.edit.report', [$apply]) }}" class="btn btn-danger">初出勤日が未登録です
                                    </a></p>
                                @endif
                                @elseif($apply->s_recruit_status === 2)
                                <a id="SaveReportStatusCancel" href="javascript:void(0)" class="adopt-cancel-btn">報告を取り消す</a>
                                <form id="seeker-apply-report-cancel-form" action="{{ route('seeker.update.report', [$apply]) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="data[Apply][id]" value="{{ $apply->id }}">
                                    <input type="hidden" name="data[Apply][pushed]" value="SaveReportCancelStatus" />
                                </form>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p class="no-jobitem-txt">応募した求人はありません。</p>
                    @endif
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

@section('js')
<script defer>
    function submit(event, form_id) {
        event.preventDefault();
        document.getElementById(form_id).submit();
    }

    $(function() {
        $("#SaveReportStatusCancel").click(function(event) {
            if (confirm("本当に報告を取り消しますか？")) {
                submit(event, 'seeker-apply-report-cancel-form');
            } else {
                return false
            }
        });
        $("#SaveReportDeclineCancel").click(function(event) {
            if (confirm("「辞退」するとお祝い金の受け取りや応募がキャンセルされます。よろしいですか？")) {
                submit(event, 'seeker-apply-report-decline-form');
            } else {
                return false
            }
        });
    });
</script>
@endsection
