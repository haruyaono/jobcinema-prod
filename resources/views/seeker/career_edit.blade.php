@extends('layouts.master')

@section('title', '現在の状況・希望編集 | JOB CiNEMA')
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
            <a href="{{route('index.seeker.mypage')}}">
                マイページ
            </a>
        </li>
        <li>
            現在の状況・希望編集
        </li>
    </ol>
</div>

<section class="main-section">
    <div class="inner">
        <div class="pad">
            <h2 class="txt-h2 mb-3">現在の状況・希望編集</h2>
            @if(Session::has('message'))
            <div class="alert alert-success">
                {{ Session::get('message') }}
            </div>
            @endif
            <div class="container mypage-container px-1">
                <div class="row justify-content-around w-100 m-0">
                    <div class="col-md-6 mt-3 px-0">
                        <div class="card mypage-card">
                            <div class="card-header">現在の状況・希望編集</div>

                            <form action="{{ route('user.career.post') }}" method="POST">
                                @csrf

                                <div class="card-body text-left">
                                    <div class="form-group">
                                        <label for="">現在の職業</label>
                                        <select name="occupation" id="">
                                            <option value="-----">-----</option>
                                            <option value="高校生" @if(Auth::user()->profile->occupation == "高校生") selected @endif>高校生</option>
                                            <option value="大学生" @if(Auth::user()->profile->occupation == "大学生") selected @endif>大学生</option>
                                            <option value="大学院生" @if(Auth::user()->profile->occupation == "大学院生") selected @endif>大学院生</option>
                                            <option value="短大生" @if(Auth::user()->profile->occupation == "短大生") selected @endif>短大生</option>
                                            <option value="専門学校生" @if(Auth::user()->profile->occupation == "専門学校生") selected @endif>専門学校生</option>
                                            <option value="アルバイト・パート" @if(Auth::user()->profile->occupation == "アルバイト・パート") selected @endif>アルバイト・パート</option>
                                            <option value="正社員" @if(Auth::user()->profile->occupation == "正社員") selected @endif>正社員</option>
                                            <option value="契約社員" @if(Auth::user()->profile->occupation == "契約社員") selected @endif>契約社員</option>
                                            <option value="派遣社員" @if(Auth::user()->profile->occupation == "派遣社員") selected @endif>派遣社員</option>
                                            <option value="主婦・主夫" @if(Auth::user()->profile->occupation == "主婦・主夫") selected @endif>主婦・主夫</option>
                                            <option value="無職" @if(Auth::user()->profile->occupation == "無職") selected @endif>無職</option>
                                        </select>
                                        @if($errors->has('occupation'))
                                        <div class="error" style="color: red;">{{ $errors->first('occupation') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">最終学歴</label>
                                        <select name="final_education" id="">
                                            <option value="-----">-----</option>
                                            <option value="大学院" @if(Auth::user()->profile->final_education == "大学院") selected @endif>大学院</option>
                                            <option value="大学" @if(Auth::user()->profile->final_education == "大学") selected @endif>大学</option>
                                            <option value="短期大学" @if(Auth::user()->profile->final_education == "短期大学") selected @endif>短期大学</option>
                                            <option value="高等専門学校" @if(Auth::user()->profile->final_education == "高等専門学校") selected @endif>高等専門学校</option>
                                            <option value="高校" @if(Auth::user()->profile->final_education == "高校") selected @endif>高校</option>
                                            <option value="中学校" @if(Auth::user()->profile->final_education == "中学校") selected @endif>中学校</option>
                                            <option value="その他" @if(Auth::user()->profile->final_education == "その他") selected @endif>その他</option>
                                        </select>
                                        @if($errors->has('final_education'))
                                        <div class="error" style="color: red;">{{ $errors->first('final_education') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <p>勤務開始可能日</p>
                                        <input id="allways" checked="checked" type="radio" name="work_start_date" value="いつでも可能" @if(Auth::user()->profile->work_start_date == "いつでも可能") checked @endif>
                                        <label for="allways">いつでも可能</label>
                                        <input id="consultation" type="radio" name="work_start_date" value="面接時に相談" @if(Auth::user()->profile->work_start_date == "面接時に相談") checked @endif>
                                        <label for="consultation">面接時に相談</label>

                                        @if($errors->has('work_start_date'))
                                        <div class="error" style="color: red;">{{ $errors->first('work_start_date') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="text-center">
                                            <button class="btn mt-3" type="submit">更新</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>

                    <div class="col-12 col-md-5 mt-3 px-0">
                        <div class="card mypage-card">
                            <div class="card-header">その他のプロフィール</div>
                            <div class="card-body text-left">
                                <p>現在の職業&nbsp:&nbsp{{ Auth::user()->profile->occupation }}</p>
                                <p>最終学歴&nbsp:&nbsp{{ Auth::user()->profile->final_education }}</p>
                                <p>勤務開始可能日&nbsp:&nbsp{{ Auth::user()->profile->work_start_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="mt-5"><i class="fas fa-arrow-left mr-1"></i><a href="/mypage/index" class="txt-blue-link">前に戻る</a></p>

        </div>
    </div>
</section>
</div>
@endsection

@section('footer')
@component('components.footer')
@endcomponent
@endsection
