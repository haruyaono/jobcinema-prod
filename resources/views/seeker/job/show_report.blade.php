@extends('layouts.master')

@section('title', '結果報告 | JOB CiNEMA')
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
            <a href="{{route('seeker.index.job')}}">
                応募管理
            </a>
        </li>
        <li>
            結果報告
        </li>
    </ol>
</div>

<div class="main-wrap">
    <section class="main-section">
        <div class="inner">
            <div class="pad">
                <h2 class="txt-h2 mb-3">結果報告</h2>
                <p class="mb-4">こちらの応募の結果を教えてください。</p>
                @if(Session::has('message'))
                <div class="alert alert-success">
                    {{ Session::get('message') }}
                </div>
                @endif
                <div class="seeker-jobapp-result-wrap">
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
                                この企業に採用されるとお祝い金<span class="ml-2">{{$apply->custom_congrats_amount}}!<span>
                            </div>
                            @endif
                        </div>
                        <div class="jobapp-item-middle">
                            <div class="jobapp-item-img only-pc">
                                @if($apply->jobitem->job_img_1)
                                <img src="{{ config('app.s3_url') . config('jobcinema.jobitem_image_dir') . $apply->jobitem->job_img_1 }}" alt="{{ $apply->company->cname }}">
                                @else
                                <img src="{{ asset('img/imacommonges/no-image.gif') }}">
                                @endif
                            </div>
                            <div class="jobapp-item-text">
                                <table>
                                    <tr>
                                        <th>応募企業</th>
                                        <td>{{$apply->company->cname}}</td>
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
                    <div class="seeker-jobapp-result-btn">
                        <a href="{{ route('seeker.edit.report', [$apply]) }}" class="btn btn-yellow"><i class="far fa-circle mr-2"></i>採用</a>
                        <a href="javascript:void(0)" class="btn btn-secondary" onclick="submit()"><i class="fas fa-times mr-2"></i>不採用</a>
                        <form id="seeker-apply-unadopt-form" action="{{ route('seeker.update.report', [$apply]) }}" method="POST" style="display: none;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="data[Apply][id]" value="{{$apply->id}}">
                            <input type="hidden" name="data[Apply][pushed]" value="SaveUnAdoptStatus" />
                        </form>
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
    function submit() {
        event.preventDefault();
        if (confirm("「不採用」で間違いありませんか？")) {
            document.getElementById('seeker-apply-unadopt-form').submit();
        } else {
            return false
        }
    }
</script>
@endsection
