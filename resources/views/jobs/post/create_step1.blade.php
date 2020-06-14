@extends('layouts.employer_mypage_master')

@section('title', '求人票| JOB CiNEMA')
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
    <div class="job-progress only-pc">
        <ul>
            <li class="current-step">
                <p class="job-step">STEP１</p>
                <p>カテゴリを選ぶ</p>
            </li>
            <li>
                <p class="job-step">STEP２</p>
                <p>詳細を入力</p>
            </li>
            <li>
                <p class="job-step">STEP３</p>
                <p>求人票を登録</p>
            </li>
            <li>
                <p>内容を確認し<br>承認作業をします</p>
            </li>
            <li>
                <p>掲載開始</p>
            </li>
        </ul>
    </div>
    <div class="col-md-10 mr-auto ml-auto p-0">
       
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
        <form  action="{{route('job.store.step1') }}" class="job-create" method="POST" enctype="multipart/form-data">@csrf
            <div class="card">
                <div class="card-header">雇用形態を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                    <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform01">
                        @foreach($categoryList[0]->all() as $statusCategory)
                        <input id="status_cat_id_{{$statusCategory->id}}" type="radio" name="status_cat_id" @if(old('status_cat_id') === $statusCategory->id) checked @elseif(intval(Session::get('data.form.category.status_cat_id')) === $statusCategory->id) checked @else @endif value={{ $statusCategory->id }}>
                        <label for="status_cat_id_{{$statusCategory->id}}">{{ $statusCategory->name }}</label><br>
                        <br>
                        @endforeach
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">募集職種を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categoryList[1]->all() as $typeCategory)
                        <div class="e-radio-item02">
                            <input id="type_cat_id_{{$typeCategory->id}}" class="" type="radio" name="type_cat_id" @if(old('type_cat_id') === $typeCategory->id) checked @elseif(intval(Session::get('data.form.category.type_cat_id')) === $typeCategory->id) checked @else @endif value={{ $typeCategory->id }}>
                            <label for="type_cat_id_{{$typeCategory->id}}">{{ $typeCategory->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">勤務地エリアを選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categoryList[2]->all() as $areaCategory)
                        <div class="e-radio-item02">
                            <input id="area_cat_id_{{$areaCategory->id}}" class="" type="radio" name="area_cat_id" @if(old('area_cat_id') === $areaCategory->id) checked @elseif(intval(Session::get('data.form.category.area_cat_id')) === $areaCategory->id) checked @else @endif value={{ $areaCategory->id }}>
                            <label for="area_cat_id_{{$areaCategory->id}}">{{ $areaCategory->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">最低時給を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categoryList[3]->all() as $hourlySalaryCategory)
                        <div class="e-radio-item02">
                            <input id="hourly_salary_cat_id_{{$hourlySalaryCategory->id}}" class="" type="radio" name="hourly_salary_cat_id" @if(old('hourly_salary_cat_id') === $hourlySalaryCategory->id) checked @elseif(intval(Session::get('data.form.category.hourly_salary_cat_id')) === $hourlySalaryCategory->id) checked @else @endif value={{ $hourlySalaryCategory->id }}>
                            <label for="hourly_salary_cat_id_{{$hourlySalaryCategory->id}}">{{ $hourlySalaryCategory->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">最低勤務日数を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categoryList[4]->all() as $dateCategory)
                        <div class="e-radio-item02">
                            <input id="date_cat_id_{{$dateCategory->id}}" class="" type="radio" name="date_cat_id" @if(old('date_cat_id') === $dateCategory->id) checked @elseif(intval(Session::get('data.form.category.date_cat_id')) === $dateCategory->id) checked @else @endif value={{ $dateCategory->id }}>
                            <label for="date_cat_id_{{$dateCategory->id}}">{{ $dateCategory->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="form-group text-center">
                    <button type="submit" class="btn btn-dark">次へ</button>
                    <a class="btn back-btn ml-3" href="javascript:void(0);" onClick="window.opener.location.reload(),window.close()"><i class="fas fa-reply mr-3"></i>閉じる</a>
            </div>
            @if(Session::has('message'))
            <div class="alert alert-success">
                {{ Session::get('message') }}
            </div>
            @endif
        </form>
    </div>
</div>  <!-- pad -->
</div>  <!-- inner --> 
</section>
</div> <!-- main-wrap -->
@endsection

@section('footer')
  @component('components.employer.mypage_footer')
  @endcomponent
@endsection


