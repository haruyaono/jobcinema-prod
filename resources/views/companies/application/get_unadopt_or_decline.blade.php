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
            <a href="{{ route('enterprise.index.mypage') }}"><span class="bread-text-color-blue">企業ページ</span></a>
        </li>
        <li>
            <a href="{{ route('enterprise.index.application') }}"><span class="bread-text-color-blue">応募一覧</span></a>
        </li>
        <li>
            <span class="bread-text-color-red">不採用・辞退一覧</span>
        </li>
    </ol>
</div>
<div class="main-wrap">
    <section class="main-section companyApplySection">
        <div class="inner">
            <div class="pad">
                <div class="sectionItemTtl">
                    <p>不採用・辞退一覧</p>
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

                    <div class="companyApplyListDesc">
                        <p class=" companyApplyListDescTtl">
                            <i class="far fa-sticky-note mr-1"></i>
                            {{ $applies->total() }}件
                        </p>
                    </div>

                    @if($applies->isNotEmpty())
                    <p class="text-right mb-3">応募データは応募から180日間表示されます。</p>
                    @foreach($applies as $apply)
                    <div class="companyApplyItem">
                        <table class="table companyTable companyApplyItemTable">
                            <tr>
                                <td colspan="4" height="39" class="cf">
                                    <div class="applyJobitem floatL">
                                        <a href="{{ route('enterprise.show.joblist.detail', $apply->jobitem) }}" target="_blank"><i class="far fa-sticky-note mr-1"></i>求人票</a>
                                    </div>
                                    @if($apply->s_recruit_status === 8)
                                    <div class="floatL ml-3">
                                        <p class="font-red font-bold font16"><i class="fas fa-exclamation-triangle mr-1"></i>応募者が辞退しました</p>
                                    </div>
                                    @endif
                                    <div class="kingaku floatR">
                                        <p class="tanka">【成果報酬額】<span class="contingent_fee">{{ $apply->recruitment_fee }}</span></p>
                                    </div>
                                </td>
                                <td rowspan="3" class="rightBox">
                                    <a class="btn companyApplyItemDetailBtn" href="{{ route('enterprise.show.application', $apply) }}" target="_blank">詳細</a>
                                </td>
                                <td rowspan="3" class="rightBox">

                                    <div class="rightBoxItem">
                                        <p class="font18 text-center">@if( $apply->e_recruit_status === 2){{ '不採用' }}@else{{ '辞退' }}@endif</p>
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
                    <p class="text-center mt-3">不採用・辞退した応募はありません</p>
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
