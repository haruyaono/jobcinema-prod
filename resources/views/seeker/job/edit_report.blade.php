@extends('layouts.master')

@section('title', '採用決定報告 | JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.header')
@endcomponent
@endsection
<style>
    #js-alert {
        color: red;
        margin-bottom: 10px;
    }
</style>
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
            <a href="{{ route('seeker.index.job')}}">
                応募管理
            </a>
        </li>
        <li>
            採用決定報告
        </li>
    </ol>
</div>

<div class="main-wrap">
    <section class="main-section">
        <div class="inner">
            <div class="pad">
                <h2 class="txt-h2 mb-3">採用決定報告</h2>
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
                @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get('message') }}
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
                        @if($apply->congrats_status !== 0)
                        <div class="header-money">
                            この企業に採用されるとお祝い金<span>{{ $apply->congrats_amount }}！</span>
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
                            </table>
                        </div>
                    </div>
                </div>

                <div class="seeker-oiwai-tabwrap">
                    <div class="tab_area">
                        <label class="tab_label active" for="tab1">初出社日が決まっている方はこちら</label>
                        <label class="tab_label" for="tab2">初出社日が未定の方はこちら</label>
                    </div>
                    <div class="panel_area">
                        <div id="panel1" class="tab_panel active">
                            <p>初出社日が決まっている方はご入力ください。<br>（研修や試用期間も初出社日に含まれます)</p>
                            <div class="form-wrap">
                                <form action="{{ route('seeker.update.report', [$apply]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="data[Apply][id]" value="{{ $apply->id }}">
                                    <input type="hidden" name="data[Apply][pushed]" value="SaveAdoptStatus" />
                                    <div class="form-label">初出社日</div>
                                    <div class="form-item">
                                        <div id="js-alert"></div>
                                        <input id="year" name="data[apply][year]" pattern="[0-9]{1,4}" onchange="inputCheck(event)" class="{{ $errors->has('data.apply.year') ? 'is-invalid' : ''}}" type="text" placeholder="西暦" maxlength="4" value="{{ old('data.apply.year') }}" required>
                                        <span>年</span>
                                        <input id="month" name="data[apply][month]" pattern="[0-9]{1,2}" type="text" onchange="inputCheck(event)" class="{{ $errors->has('data.apply.month') ? 'is-invalid' : ''}}" maxlength="2" value="{{ old('data.apply.month') }}" required>
                                        <span>月</span>
                                        <input id="date" name="data[apply][date]" pattern="[0-9]{1,2}" type="text" onchange="inputCheck(event)" class="{{ $errors->has('data.apply.date') ? 'is-invalid' : ''}}" maxlength="2" value="{{ old('data.apply.date') }}" required>
                                        <span>日</span>
                                        <input type="submit" name="adopt_submit1" class="btn btn-yellow" value="報告する">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="panel2" class="tab_panel">
                            <p>採用が決定していて、初出社日が分からない場合は状況をご記入ください。</p>
                            <div class="form-wrap">
                                <form action="{{ route('seeker.update.report', [$apply]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="data[Apply][id]" value="{{ $apply->id }}">
                                    <input type="hidden" name="data[Apply][pushed]" value="SaveTmpAdoptStatus" />
                                    <textarea name="data[apply][s_nofirst_attendance]" placeholder="例）初出社日の連絡待ちです。○月上旬頃出社予定です。" class="{{ $errors->has('data.apply.s_nofirst_attendance') ? 'is-invalid' : ''}}" rows="6" required>@if(old('data.apply.s_nofirst_attendance')){{ old('data.apply.s_nofirst_attendance') }}@else{{$apply->s_nofirst_attendance ?: '' }}@endif</textarea>
                                    <input type="submit" name="adopt_submit2" class="btn btn-yellow" value="報告する">
                                </form>
                            </div>
                        </div>
                    </div>
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
