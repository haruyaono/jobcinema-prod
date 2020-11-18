@extends('layouts.employer_mypage_master')

@section('title', '求人票一覧 | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.employer.mypage_header')
@endcomponent
@endsection

@section('contents')
<!-- 削除確認 -->
<div id='del_confirm' style="display:none;">
    <div class='delConfirmHeader'>求人票番号：<span class="confirm_sheet_id"></span> の求人票を削除しますか？</div>
    <div class='delConfirmHeaderMessage'>
        <p class="delConfirmHeaderMessageTtl">下記の注意事項をご確認下さい</p>
        <ul>
            <li>削除した求人票は元に戻せません。</li>
            <li>今後ご利用になる可能性のある求人票は削除しないで下さい。</li>
            <li>掲載中の求人票の掲載を止めたい場合は［掲載をやめる］ボタンを押して下さい。</li>
            <li class="last">承認待ちの求人票を変更したい場合は［申請を取り消す］ボタンを押して下さい。</li>
        </ul>
    </div>
</div>

<!-- パンくず -->
<div id="breadcrumb" class="e-mypage-bread only-pc">
    <ol>
        <li>
            <a href="{{ route('enterprise.index.mypage') }}"><span class="bread-text-color-blue">企業ページ</span></a>
        </li>
        <li>
            <span class="bread-text-color-red">求人票の作成・確認</span>
        </li>
    </ol>
</div>
<div class="main-wrap">
    <section class="main-section companyJobsheetJoblistSection">
        <div class="inner">
            <div class="pad">
                <div class="row w-100 m-0  justify-content-center">
                    <div class="col-12 px-0">
                        @if(Session::has('message_alert'))
                        <div class="alert alert-danger">
                            {{ Session::get('message_alert') }}
                        </div>
                        @endif
                        @if(Session::has('message_success'))
                        <div class="alert alert-success">
                            {{ Session::get('message_success') }}
                        </div>
                        @endif
                        <div class="sectionItemTtl">
                            <p>求人票をつくる</p>
                        </div>
                        <div class="sectionItem">
                            <div class="py-2 px-3 border-gold border-w3">
                                【求人票を作成における注意点】<br>
                                求人票は雇用形態別に作成ください<br>
                                ＜正社員＞<br class="only-sp">職種別・都道府県ごとに1つ作成してください。<br>
                                ＜契約社員＞<br class="only-sp">職種別・都道府県ごとに1つ作成してください。<br>
                                ＜アルバイト・パート＞<br class="only-sp">職種別・市区町村ごとに1つ作成してください。<br><br>
                                例）<br class="only-sp">アルバイト・パートと社員を同時に掲載する場合<br>アルバイト・パートで１つ、社員で１つ作成します。<br>アルバイト・パートの求人票の中に社員募集の条件などを記載することはNGです。<br>同様に、社員の求人票の中にアルバイト・パート募集の条件などを記載することはNGです。<br>
                                <div class="btn-wrap mt-3">
                                    <a href="{{ route('enterprise.index.jobsheet.step1') }}" class="font-yellow font20" target="_blank">＋求人票を新規作成</a>
                                </div>
                            </div>
                        </div>

                        <div class="sectionItemTtl">
                            <p>求人一覧</p>
                        </div>
                        <div class="sectionItem">
                            @if($jobitems->count() > 0)
                            @foreach($jobitems as $jobitem)
                            <div class="card companyJobsheetJobItem">
                                <div class="card-header companyJobsheetJobItemHeader cf">
                                    <p class="floatL companyJobsheetJobItemHeaderTtl">求人番号：{{ $jobitem->id }}</p>
                                    <div class="floatR alignright">
                                        <a href="javascript:void(0);" id="deleteConfirmBtn{{$jobitem->id}}" onclick="return del_confirm(this, {{$jobitem->id}});"><span class="fs10"><i class="far fa-trash-alt"></i>この求人票を削除</span></a>
                                    </div>
                                </div>
                                <div class="card-body companyJobsheetJobItemBody">
                                    <table cellspacing="0" cellpadding="0" class="table companyJobsheetJobitemTable">
                                        <tr>
                                            <td colspan="4" height="39" class="kingaku">
                                                <div class="kingakuWrap">
                                                    <div class="kingaku">
                                                        <p class="tanka">成果報酬単価：<span class="contingent_fee">{{ $jobitem->categories()->wherePivot('ancestor_slug', 'status')->first()->achievementReward->CostomAmount}}</span></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td rowspan="3" class="sheetBtnBox">
                                                <div class="statusTxt statusTxt-{{$jobitem->status}}">
                                                    @if($jobitem->status === 2 && $jobitem->pub_start_date > date("Y-m-d", strtotime('+1 day')))
                                                    {{ '掲載待ち' }}
                                                    @else
                                                    {{config('const.EMP_JOB_STATUS.'.$jobitem->status)}}
                                                    @endif
                                                </div>
                                                <a class="btn companyJobsheetJoblistBtn joblistShowBtn" href="{{ route('enterprise.show.joblist.detail', [$jobitem]) }}" target="_blank">
                                                    <i class="fas fa-desktop mr-1"></i>求人票を確認する
                                                </a><br>
                                                @if($jobitem->status === 0)
                                                <a class="btn companyJobsheetJoblistBtn joblistEditBtn" href="{{ route('enterprise.edit.jobsheet.step2', [$jobitem]) }}" target="_blank">
                                                    <i class="far fa-edit mr-1"></i>変更・掲載する
                                                </a>
                                                @elseif ($jobitem->status === 1)
                                                <a class="btn companyJobsheetJoblistBtn joblistCancelBtn" href="{{ route('enterprise.edit.jobsheet.status.apply_cancel', [$jobitem]) }}" target="_blank">
                                                    <i class="fas fa-ban mr-1"></i>申請を取り消す
                                                </a>
                                                @elseif ($jobitem->status === 2)
                                                <a class="btn companyJobsheetJoblistBtn joblistEditBtn" href="{{ route('enterprise.edit.jobsheet.step2', [$jobitem]) }}" target="_blank">
                                                    <i class="far fa-edit mr-1"></i>求人票を変更する
                                                </a>
                                                <a class="btn companyJobsheetJoblistBtn joblistCancelBtn" href="{{ route('enterprise.edit.jobsheet.status.postend', [$jobitem]) }}" target="_blank">
                                                    <i class="fas fa-ban mr-1"></i>掲載をやめる
                                                </a>
                                                @elseif ($jobitem->status == 3)
                                                <a class="btn companyJobsheetJoblistBtn joblistEditBtn" href="{{ route('enterprise.edit.jobsheet.step2', [$jobitem]) }}" target="_blank">
                                                    <i class="far fa-edit mr-1"></i>変更・再掲載する
                                                </a>
                                                @elseif ($jobitem->status == 4)
                                                <a class="btn companyJobsheetJoblistBtn joblistEditBtn" href="{{ route('enterprise.edit.jobsheet.step2', [$jobitem]) }}" target="_blank">
                                                    <i class="far fa-edit mr-1"></i>変更・再掲載する
                                                </a>
                                                @endif
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>雇用形態</th>
                                            <td>
                                                @foreach($jobitem->categories as $category)
                                                @if($category->parent->slug == 'status')
                                                {{$category->name}}
                                                @endif
                                                @endforeach
                                            </td>
                                            <th>勤務先名</th>
                                            <td>
                                                {{ $jobitem->job_office}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>職種</th>
                                            <td>
                                                @foreach($jobitem->categories as $category)
                                                @if($category->parent->slug == 'type')
                                                {{$category->name}}
                                                @endif
                                                @endforeach
                                            </td>
                                            <th>掲載期間</th>
                                            <td>
                                                {{ $jobitem->start_date }} から {{ $jobitem->end_date}}
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <p class="text-center mt-3">作成された求人票はありません。</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="paginate text-center">
                    {{ $jobitems->appends(Illuminate\Support\Facades\Request::except('page'))->links()}}
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
<script>
    function del_confirm(obj, sheet_id) {
        $('.confirm_sheet_id').text(sheet_id);
        var modal = new tingle.modal({
            footer: true,
        });
        var modalContent = document.getElementById('del_confirm');
        if (modalContent) {

            modal.setContent(modalContent.innerHTML);

            modal.addFooterBtn('キャンセル', 'btn', function() {
                modal.close();
            });
            modal.addFooterBtn('削除する', 'btn btn-secondary', function() {
                modal.close();
                $(obj).prop('disabled', true);
                location.href = '/enterprise/joblist/job/delete/' + sheet_id;
            });

            modal.open();
        }
    }
</script>

@endsection
