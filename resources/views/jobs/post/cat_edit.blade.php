<?php
if( ! function_exists('is_route'))
{
    /**
     * Alias for Request::is(route(...))
     *
     * @return mixed
     */
    function is_route()
    {
        $args = func_get_args();
        foreach($args as &$arg)
        {
            if(is_array($arg))
            {
                $route = array_shift($arg);
                $arg = ltrim(route($route, $arg, false), '/');
                continue;
            }
            $arg = ltrim(route($arg, [], false), '/');
        }
        return call_user_func_array(array(app('request'), 'is'), $args);
    }
}
?>
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
    <div class="col-md-10 mr-auto ml-auto">
       
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
        <form  action="{{route('job.category.update', [$jobItem->id]) }}" class="job-create" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="cat_flag" value="{{$cat_slug}}">
        @if(is_route(['job.category.edit', $jobItem->id,'category'=>'status']))
            <div class="card">
            
                <div class="card-header">雇用形態を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                    <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform01">
                        @foreach($categories as $pIndex => $category)
                        <input id="status_cats_{{$pIndex}}" type="radio" name="cats_status[id]" @if(Session::has('data.form.edit_category.cats_status.id')) {{Session::get('data.form.edit_category.cats_status.id') == $category->id ? 'checked' : ''}}@else @foreach($jobItem->categories as $jCat)@if($jCat->id == $category->id) checked @endif @endforeach @endif value="{{ $category->id }}">
                        <label for="status_cats_{{$pIndex}}">{{ $category->name }}</label><br>
                        <br>
                        @endforeach
                        <input type="hidden" name="cats_status[slug]" value="{{$categories->first()->parent->slug}}">
                        <input type="hidden" name="cats_status[parent_id]" value="{{$categories->first()->parent->id}}">
                    </div>
                </div>
            </div> <!-- card --> 
        @endif
        @if(is_route(['job.category.edit', $jobItem->id,'category'=>'type']))
           
            <div class="card">
                <div class="card-header">募集職種を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categories as $pIndex => $category)
                        <div class="e-radio-item02">
                            <input id="type_cats_{{$pIndex}}" class="" type="radio" name="cats_type[id]" @if(Session::has('data.form.edit_category.cats_type.id')) {{Session::get('data.form.edit_category.cats_type.id') == $category->id ? 'checked' : ''}}@else @foreach($jobItem->categories as $jCat)@if($jCat->id == $category->id) checked @endif @endforeach @endif value="{{ $category->id }}">
                            <label for="type_cats_{{$pIndex}}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                        <input type="hidden" name="cats_type[slug]" value="{{$categories->first()->parent->slug}}">
                        <input type="hidden" name="cats_type[parent_id]" value="{{$categories->first()->parent->id}}">
                    </div>
                </div>
            </div> <!-- card --> 
        @endif
        @if(is_route(['job.category.edit', $jobItem->id,'category'=>'area']))
            <div class="card">
                <div class="card-header">勤務地エリアを選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categories as $pIndex => $category)
                        <div class="e-radio-item02">
                            <input id="area_cats_{{$pIndex}}" class="" type="radio" name="cats_area[id]" @if(Session::has('data.form.edit_category.cats_area.id')) {{Session::get('data.form.edit_category.cats_area.id') == $category->id ? 'checked' : ''}}@else @foreach($jobItem->categories as $jCat)@if($jCat->id == $category->id) checked @endif @endforeach @endif value="{{ $category->id }}">
                            <label for="area_cats_{{$pIndex}}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                        <input type="hidden" name="cats_area[slug]" value="{{$categories->first()->parent->slug}}">
                        <input type="hidden" name="cats_area[parent_id]" value="{{$categories->first()->parent->id}}">
                    </div>
                </div>
            </div> <!-- card --> 
        @endif
        @if(is_route(['job.category.edit', $jobItem->id,'category'=>'salary']))
            <div class="card">
                <div class="card-header">最低給与を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※複数選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categories as $pIndex => $category)
                        <div class="e_radio_cat_item_salary">
                            <div class="e_radio_cat_item_p_salary">
                                <input id="salary_cats_{{$pIndex}}" class="jc-jsc-salary-money-selectfield" type="checkbox" name="cats_salary_p[id][]" @if(Session::get('data.form.edit_category.cats_salary_p.id.'.$pIndex) == $category->id ) checked @else @foreach($jobItem->categories as $jCat)@if($jCat->parent->id == $category->id) checked @endif @endforeach @endif value={{ $category->id }}>
                                <label for="salary_cats_{{$pIndex}}">{{ $category->name }}</label>
                            </div>

                            <select name="cats_salary[id][]" id="e_radio_cat_item_c_salary_{{$pIndex}}" class="e_radio_cat_item_c_salary">
                                @foreach($category->children->sortBy('id') as $cIndex => $cat)
                                    <option value="{{$cat->id}}" @if(intval(Session::get('data.form.edit_category.cats_salary.id.' . $pIndex)) === $cat->id) selected @else @foreach($jobItem->categories as $jCat)@if($jCat->id == $cat->id) selected @endif @endforeach @endif>{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                        <input type="hidden" name="cats_salary[slug]" value="{{$categories->first()->parent->slug}}">
                        <input type="hidden" name="cats_salary[parent_id]" value="{{$categories->first()->parent->id}}">
                    </div>
                </div>
            </div> <!-- card --> 
        @endif
        @if(is_route(['job.category.edit', $jobItem->id,'category'=>'date']))
    
            <div class="card">
                <div class="card-header">最低勤務日数を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach($categories as $pIndex => $category)
                        <div class="e-radio-item02">
                            <input id="date_cats_{{$pIndex}}" class="" type="radio" name="cats_date[id]" @if(Session::has('data.form.edit_category.cats_date.id')) {{Session::get('data.form.edit_category.cats_date.id') == $category->id ? 'checked' : ''}}@else @foreach($jobItem->categories as $jCat)@if($jCat->id == $category->id) checked @endif @endforeach @endif value="{{ $category->id }}">
                            <label for="date_cats_{{$pIndex}}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                        <input type="hidden" name="cats_date[slug]" value="{{$categories->first()->parent->slug}}">
                        <input type="hidden" name="cats_date[parent_id]" value="{{$categories->first()->parent->id}}">
                    </div>
                </div>
            </div> <!-- card --> 
        @endif
            <div class="form-group text-center">
                    <button type="submit" class="btn btn-dark">変更</button>
                    <a class="btn back-btn ml-3" href="javascript:void(0);" onClick="javascript:window.history.back(-1);return false;"><i class="fas fa-reply mr-3"></i>戻る</a>
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


