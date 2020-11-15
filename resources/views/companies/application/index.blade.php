@extends('layouts.employer_mypage_master')

@section('title', '応募者一覧| JOB CiNEMA')
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
            <span class="bread-text-color-red">応募一覧</span>
        </li>
    </ol>
</div>
<div class="main-wrap">
    <section class="main-section companyApplySection">
        <div class="inner">
            <div class="pad">
                <div class="sectionItemTtl">
                    <p>応募管理</p>
                </div>
                <div class="sectionItem">
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

                    <div class="companyApplyItem d-flex">
                        <div class="companyApplyNote">
                            <p class="font-red companyApplyNoteTtl">応募者の対応について</p>
                            <ul>
                                <li>合否判定は必ず詳細画面から行って下さい。</li>
                            </ul>
                        </div>
                        <div class="companyApplyGavage">
                            <a href="{{ route('get.company.application.unadopt_or_decline') }}" class="btn companyBtn companyBtnBlue"><i class="fas fa-user-times mr-1"></i>不採用・辞退した応募</a>
                        </div>
                    </div>

                    <div class="companyApplyListDesc">
                        <p class=" companyApplyListDescTtl">
                            <i class="far fa-sticky-note mr-1"></i>
                            @if($applies->total() === 0 ){{ '0' }}@else{{ $applies->firstItem() }} ~ {{ $applies->lastItem() }}@endif 件表示 / 全{{ $applies->total() }}件
                        </p>
                        <p class="mb-2">(未閲覧 : {{ $data['unread'] }}件 / 未処理 : {{ $data['untreated'] }}件)</p>
                        <p>未読の応募を確認して下さい。</p>
                    </div>

                    @if($applies->isNotEmpty())
                    <p class="text-right mb-3">応募データは応募から180日間表示されます。</p>
                    @foreach($applies as $apply)
                    <div class="companyApplyItem">
                        <table class="table companyTable companyApplyItemTable">
                            <tr>
                                <td colspan="4" height="39" class="cf">
                                    <div class="applyJobitem floatL">
                                        <a href="{{ route('show.joblist.detail', $apply->jobitem) }}" target="_blank"><i class="far fa-sticky-note mr-1"></i>求人票</a>
                                    </div>

                                    <div class="floatL ml-3">
                                        @if($apply->s_recruit_status === 8)
                                        <p class="font-red font-bold font14">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            応募者が辞退しました
                                        </p>
                                        @endif
                                        @if($apply->e_recruit_status === 1 && !$apply->e_first_attendance)
                                        <p class="font-red font-bold font14">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            初出社日が未入力です
                                        </p>
                                        @endif
                                    </div>
                                    <div class="kingaku floatR">
                                        <p class="tanka">【成果報酬額】<span class="contingent_fee">{{ $apply->recruitment_fee }}</span></p>
                                    </div>
                                </td>
                                <td rowspan="3" class="rightBox">
                                    <a class="btn companyApplyItemDetailBtn" href="{{ route('show.company.application', $apply) }}" target="_blank">詳細</a>
                                </td>
                                <td rowspan="3" class="rightBox">
                                    @if($apply->e_recruit_status === 0 || !$apply->e_first_attendance)
                                    <div class="rightBoxItem">
                                        @if($apply->days_left > 0)
                                        <p class="daysLeftTxt">残り<span class="font-red">{{ $apply->days_left }}</span>日</p>
                                        @else
                                        <p class="daysLeftTxt"><span class="font-red">{{ '期限切れ' }}</span></p>
                                        @endif
                                    </div>
                                    @endif

                                    <div class="rightBoxItem">
                                        @if( $apply->read === 0)
                                        <p class="newNotify">NEW</p>
                                        @else
                                        <p class="font18 text-center">{{ config('const.RECRUITMENT_STATUS.' . $apply->e_recruit_status) }}</p>
                                        @endif
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <th>応募日</th>
                                <td>
                                    {{ $apply->getCreatedAtTransform('Y年m月d日')}}
                                </td>
                                <th>職種</th>
                                <td>
                                    {{ $apply->jobitem->categories()->wherePivot('ancestor_slug', 'type')->first()->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>雇用形態</th>
                                <td>
                                    {{ $apply->jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->name }}
                                </td>
                                <th>勤務先名</th>
                                <td>
                                    {{ $apply->jobitem->job_office }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    @endforeach
                    @if($applies instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                    <div class="paginateWrap">
                        {{ $applies->links() }}
                    </div>
                    @endif
                    @else
                    <p class="text-center mt-3">現在、応募者はいません。</p>
                    @endif

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
