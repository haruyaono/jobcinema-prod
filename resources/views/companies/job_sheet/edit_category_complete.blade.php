@extends('layouts.employer_mypage_master')

@section('title', '求人票の申請取り消し | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.employer.mypage_header')
@endcomponent
@endsection

@section('contents')
<div class="main-wrap">
    <section class="main-section job-create-section">
        <div class="inner">
            <div class="pad">
                <div class="col-md-10 mr-auto ml-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="my-3">
                                <input type="hidden" name="data[JobSheet][currentCategory]" value="{{$categories}}" id="CurrentCategory">
                                <?php
                                $message = 'カテゴリを更新しました！';
                                switch ($categoryFlag) {
                                    case 'status':
                                        $message = '雇用形態カテゴリ';
                                        break;
                                    case 'type':
                                        $message = '職種カテゴリ';
                                        break;
                                    case 'area':
                                        $message = '勤務地カテゴリ';
                                        break;
                                    case 'salary':
                                        $message = '給与カテゴリ';
                                        break;
                                    case 'date':
                                        $message = '最低勤務日数カテゴリ';
                                        break;
                                }
                                ?>
                                    <p class="after-text h3">{{$message}}を更新しました！</p>
                            </div>
                        </div>
                    </div> <!-- card -->
                    <div class="form-group text-center">
                        <a class="btn back-btn ml-3" href="javascript:void(0);" onClick="window.close()"><i class="fas fa-reply mr-3"></i>閉じる</a>
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


@section('js')
<script>
    $(function() {
        var categorySlug = @json($categoryFlag).charAt(0).toUpperCase() + @json($categoryFlag).slice(1),
            salarySlug = @json($categorySalarySlug),
            categories = $('#CurrentCategory').val(),
            html = '';

        const categoriesArr = JSON.parse(categories);

        if (categorySlug == 'Salary') {
            for (let i = -1; i < salarySlug.length; i++) {
                if (salarySlug[i] == 'salary_h') {
                    html += '<p>時給: ' + categoriesArr[i].name + '</p>';
                } else if (salarySlug[i] == 'salary_d') {
                    html += '<p>日給: ' + categoriesArr[i].name + '</p>';
                } else if (salarySlug[i] == 'salary_m') {
                    html += '<p>月給: ' + categoriesArr[i].name + '</p>';
                } else {
                    html = '';
                }
            }
        } else {
            categoriesArr.forEach(category => {
                html = '<p>' + category.name + '</p>';
            });
        }

        window.opener.$("#JobSheetStep2Category" + categorySlug + "Name").html(html);
    });
</script>
@endsection
