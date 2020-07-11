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
                        @foreach($categoryList[0]->children as $pIndex => $statusCategory)
                        <input id="status_cats_{{$pIndex}}" type="radio" name="cats_status[id]" @if(intval(old('cats_status.id')) == $statusCategory->id) checked @elseif(intval(Session::get('data.form.category.cats_status.id')) === $statusCategory->id) checked @else @endif value={{ $statusCategory->id }}>
                        <label for="status_cats_{{$pIndex}}">{{ $statusCategory->name }}</label><br>
                        <br>
                        @endforeach
                        <input type="hidden" name="cats_status[slug]" value="{{$categoryList[0]->slug}}">
                        <input type="hidden" name="cats_status[parent_id]" value="{{$categoryList[0]->id}}">
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">募集職種を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categoryList[1]->children as $pIndex => $typeCategory)
                        <div class="e-radio-item02">
                            <input id="type_cats_{{$pIndex}}" class="" type="radio" name="cats_type[id]" @if(intval(old('cats_type.id')) === $typeCategory->id) checked @elseif(intval(Session::get('data.form.category.cats_type.id')) === $typeCategory->id) checked @else @endif value={{ $typeCategory->id }}>
                            <label for="type_cats_{{$pIndex}}">{{ $typeCategory->name }}</label>
                        </div>
                        @endforeach
                        <input type="hidden" name="cats_type[slug]" value="{{$categoryList[1]->slug}}">
                        <input type="hidden" name="cats_type[parent_id]" value="{{$categoryList[1]->id}}">
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">勤務地エリアを選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categoryList[2]->children as $pIndex => $areaCategory)
                        <div class="e-radio-item02">
                            <input id="area_cats_{{$pIndex}}" class="" type="radio" name="cats_area[id]" @if(intval(old('cats_area.id')) === $areaCategory->id) checked @elseif(intval(Session::get('data.form.category.cats_area.id')) === $areaCategory->id) checked @else @endif value={{ $areaCategory->id }}>
                            <label for="area_cats_{{$pIndex}}">{{ $areaCategory->name }}</label>
                        </div>
                        @endforeach
                        <input type="hidden" name="cats_area[slug]" value="{{$categoryList[2]->slug}}">
                        <input type="hidden" name="cats_area[parent_id]" value="{{$categoryList[2]->id}}">
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">最低給与を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※複数選択できます</p>
                    <div class="form-group e-radioform e-salary-form">
                        @foreach($categoryList[3]->children as $pIndex => $salaryCategory)
                        <div class="e_radio_cat_item_salary">
                            <div class="e_radio_cat_item_p_salary">
                                <input id="salary_cats_{{$pIndex}}" class="jc-jsc-salary-money-selectfield" type="checkbox" name="cats_salary_p[id][]" @if(intval(old('cats_salary_p.id.' . $pIndex)) === $salaryCategory->id) checked @elseif(intval(Session::get("data.form.category.cats_salary_p.id.$pIndex")) === $salaryCategory->id) checked @else @endif value={{ $salaryCategory->id }}>
                                <label for="salary_cats_{{$pIndex}}">{{ $salaryCategory->name }}</label>
                            </div>
                            <select name="cats_salary[id][]" id="e_radio_cat_item_c_salary_{{$pIndex}}" class="e_radio_cat_item_c_salary">
                                @foreach($salaryCategory->children as $cIndex => $cat)
                                    <option value="{{$cat->id}}" @if(intval(old('cats_salary.id.' . $pIndex)) === $cat->id) selected @elseif(intval(Session::get('data.form.category.cats_salary.id.' . $pIndex)) === $cat->id) selected @else @endif>{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                        <input type="hidden" name="cats_salary[slug]" value="{{$categoryList[3]->slug}}">
                        <input type="hidden" name="cats_salary[parent_id]" value="{{$categoryList[3]->id}}">
                    </div>
                </div>
            </div> <!-- card --> 
            <div class="card">
                <div class="card-header">最低勤務日数を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categoryList[4]->children as $pIndex => $dateCategory)
                        <div class="e-radio-item02">
                            <input id="date_cats_{{$pIndex}}" class="" type="radio" name="cats_date[id]" @if(intval(old('cats_date.id')) === $dateCategory->id) checked @elseif(intval(Session::get('data.form.category.cats_date.id')) === $dateCategory->id) checked @else @endif value={{ $dateCategory->id }}>
                            <label for="date_cats_{{$pIndex}}">{{ $dateCategory->name }}</label>
                        </div>
                        @endforeach
                        <input type="hidden" name="cats_date[slug]" value="{{$categoryList[4]->slug}}">
                        <input type="hidden" name="cats_date[parent_id]" value="{{$categoryList[4]->id}}">
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


