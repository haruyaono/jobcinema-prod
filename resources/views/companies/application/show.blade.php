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
            <span class="bread-text-color-red">応募詳細</span>
        </li>
    </ol>
</div>
<div class="main-wrap">
    <section class="main-section companyApplySection">
        <div class="inner">
            <div class="pad">
                <div class="sectionItemTtl">
                    <p>応募求人</p>
                </div>
                <div class="sectionItem">
                    <table class="table companyTable companyApplyItemTable">
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

                <div class="sectionItemTtl">
                    <p>応募者</p>
                </div>
                <div class="sectionItem">
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
                            <th>電話番号</th>
                            <td>
                                {{ $apply->detail->phone1 }} - {{ $apply->detail->phone2 }} - {{ $apply->detail->phone3 }}
                            </td>
                        </tr>
                        <tr>
                            <th>住所</th>
                            <td>
                                〒 {{ $apply->detail->postcode }}<br>
                                {{ $apply->detail->prefecture }} {{ $apply->detail->city }}
                            </td>
                        </tr>
                        <tr>
                            <th>職業</th>
                            <td>
                                {{ $apply->detail->occupation }}
                            </td>
                        </tr>
                        <tr>
                            <th>最終学歴</th>
                            <td>
                                {{ $apply->detail->final_education }}
                            </td>
                        </tr>
                        <tr>
                            <th>勤務開始可能日</th>
                            <td>
                                {{ $apply->detail->work_start_date }}
                            </td>
                        </tr>
                        <tr>
                            <th>志望動機</th>
                            <td>
                                {!! nl2br(e($apply->detail->job_msg)) !!}
                            </td>
                        </tr>
                        @for($i = 1; $i <= 3; $i++) <tr>
                            @if($apply->detail->{"job_q".$i})
                            <th>質問{{$i}} ({{ $apply->jobitem->{"job_q".$i} }})</th>
                            <td>
                                {!! nl2br(e($apply->detail->{"job_q".$i})) !!}
                            </td>
                            </tr>
                            @endif
                            @endfor
                    </table>
                </div>

                @if($apply->recruitment_status == 1)
                <div class="sectionItemTtl">
                    <p>採用処理</p>
                </div>
                <div class="sectionItem">
                    <div class="companyBtnWrap">
                        <a href="{{ route('enterprise.show.application.report', [$apply, 'type' => 'adopt']) }}" class="companyBtn companyBtnOrange">採用決定</a>
                        <a href="{{ route('enterprise.show.application.report', [$apply, 'type' => 'unadopt']) }}" class="companyBtn companyBtnGray">不採用</a>
                        <a href="{{ route('enterprise.show.application.report', [$apply, 'type' => 'decline']) }}" class="companyBtn companyBtnCyan">辞退</a>
                    </div>
                </div>
                @elseif($apply->recruitment_status == 2)
                    @if($apply->achieve_reward->is_payed)
                        @if(strtotime(date("Y-m-d",strtotime($apply->recruit_confirm . "+30 day"))) >= strtotime(date("Y-m-d")))
                        <div class="sectionItemTtl">
                            <p>成果報酬返金依頼</p>
                        </div>
                        <div class="sectionItem">
                            <div class="companyBtnWrap">
                                @if($apply->achieve_reward->is_return_requested == 1)
                                    @if($apply->achieve_reward->is_returned == 1)
                                    <p>返金済み</p>
                                    @else
                                    <p>返金依頼済み</p>
                                    @endif
                                @else
                                <a href="{{ route('enterprise.update.application.achieve_reward_rev', ['apply' => $apply]) }}" class="companyBtn companyBtnOrange">返金依頼</a>
                                @endif
                            </div>
                        </div>
                        @endif
                    @else
                    <div class="sectionItemTtl">
                        <p>成果報酬振り込み先</p>
                    </div>
                    <div class="sectionItem">
                        <table class="table companyTable companyApplyItemTable">
                            <tr>
                                <th>銀行名</th>
                                <td>釧路信用金庫</td>
                            </tr>
                            <tr>
                                <th>銀行コード</th>
                                <td>1027</td>
                            </tr>
                            <tr>
                                <th>支店名</th>
                                <td>本店</td>
                            </tr>
                            <tr>
                                <th>支店コード</th>
                                <td>001</td>
                            </tr>
                            <tr>
                                <th>口座番号</th>
                                <td>1334827</td>
                            </tr>
                            <tr>
                                <th>口座名義</th>
                                <td>ド）リブラス</td>
                            </tr>
                            <tr>
                                <th>振り込み金額</th>
                                <td>{{ number_format($apply->recruitment_fee) }} 円</td>
                            </tr>
                        </table>
                        <div class="companyBtnWrap">
                            <a href="{{ route('enterprise.update.application.achieve_reward', ['apply' => $apply]) }}" class="companyBtn companyBtnOrange">振り込みました</a>
                        </div>
                    </div>
                    @endif
                @endif

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
