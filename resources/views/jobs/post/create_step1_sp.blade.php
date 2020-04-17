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
                        <select name="status_cat_id" id="">
                            <option value="">選択してください</option>
                            @foreach(App\Models\StatusCat::all() as $statusCat)
                            <option id="status_cat_id_{{$statusCat->id}}"  {{ old('status_cat_id') == $statusCat->id ? 'selected' : ''}}@if(Session::has('data.form.category.status_cat_id') && !old('status_cat_id')) {{Session::get('data.form.category.status_cat_id') == $statusCat->id ? 'selected' : ''}} @endif value="{{ $statusCat->id }}">{{ $statusCat->name }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">募集職種を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        <select name="type_cat_id" id="">
                            <option value="">選択してください</option>
                            @foreach(App\Models\TypeCat::all() as $typeCat)
                            <option id="type_cat_id_{{$typeCat->id}}"  {{ old('type_cat_id') == $typeCat->id ? 'selected' : ''}}@if(Session::has('data.form.category.type_cat_id') && !old('type_cat_id')) {{Session::get('data.form.category.type_cat_id') == $typeCat->id ? 'selected' : ''}} @endif value="{{ $typeCat->id }}">{{ $typeCat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">勤務地エリアを選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        <select name="area_cat_id" id="">
                            <option value="">選択してください</option>
                            @foreach(App\Models\AreaCat::all() as $areaCat)
                            <option id="area_cat_id_{{$areaCat->id}}"  {{ old('area_cat_id') == $areaCat->id ? 'selected' : ''}}@if(Session::has('data.form.category.area_cat_id') && !old('area_cat_id')) {{Session::get('data.form.category.area_cat_id') == $areaCat->id ? 'selected' : ''}} @endif value="{{ $areaCat->id }}">{{ $areaCat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">最低時給を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        <select name="hourly_salary_cat_id" id="">
                            <option value="">選択してください</option>
                            @foreach(App\Models\HourlySalaryCat::all() as $hourlySalaryCat)
                            <option id="hourly_salary_cat_id_{{$areaCat->id}}"  {{ old('hourly_salary_cat_id') == $hourlySalaryCat->id ? 'selected' : ''}}@if(Session::has('data.form.category.hourly_salary_cat_id') && !old('hourly_salary_cat_id')) {{Session::get('data.form.category.hourly_salary_cat_id') == $hourlySalaryCat->id ? 'selected' : ''}} @endif value="{{ $hourlySalaryCat->id }}">{{ $hourlySalaryCat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">最低勤務日数を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        <select name="date_cat_id" id="">
                            <option value="">選択してください</option>
                            @foreach(App\Models\DateCat::all() as $dateCat)
                            <option id="date_cat_id_{{$dateCat->id}}"  {{ old('date_cat_id') == $dateCat->id ? 'selected' : ''}}@if(Session::has('data.form.category.date_cat_id') && !old('date_cat_id')) {{Session::get('data.form.category.date_cat_id') == $dateCat->id ? 'selected' : ''}} @endif value="{{ $dateCat->id }}">{{ $dateCat->name }}</option>
                            @endforeach
                        </select>
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


