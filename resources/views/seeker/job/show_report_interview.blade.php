@extends('layouts.master')

@section('title', '面接日を設定 | JOB CiNEMA')
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
                面接日を設定
            </li>
        </ol>
    </div>

    <div class="main-wrap">
        <section class="main-section">
            <div class="inner">
                <div class="pad">
                    <h2 class="txt-h2 mb-3">面接日を設定</h2>
                    <p class="mb-4">こちらの応募の面接日を教えてください。</p>
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
                                    この企業に採用されるとお祝い金<span class="ml-2">{{$apply->custom_congrats_amount}}!</span>
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
                    </div>
                    <div class="mypage-card">
                        <form action="{{ route('seeker.update.report_interview', [$apply]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="d-block" for="">面接日</label>
                                <input type="date" class="form-control w-25 d-inline-block" name="data[interview]">
                            </div>
                            <div class="form-group">
                                <button class="btn mt-2" type="submit">更新</button>
                            </div>
                        </form>
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