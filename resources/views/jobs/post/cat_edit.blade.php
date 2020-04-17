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
        <form  action="{{route('job.category.update', [$job->id]) }}" class="job-create" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="cat_flag" value="{{$category}}">
        @if(is_route(['job.category.edit', $job->id,'category'=>'status']))
            <div class="card">
            
                <div class="card-header">雇用形態を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                    <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform01">
                        @foreach(App\Models\StatusCat::all() as $statusCat)
                        <input id="status_cat_id_{{$statusCat->id}}" type="radio" name="status_cat_id" @if(Session::has('data.form.edit_category.status')) {{Session::get('data.form.edit_category.status') == $statusCat->id ? 'checked' : ''}}@else {{$job->status_cat_id == $statusCat->id ? 'checked' : ''}} @endif value="{{ $statusCat->id }}">
                        <label for="status_cat_id_{{$statusCat->id}}">{{ $statusCat->name }}</label><br>
                        <br>
                        @endforeach
                    </div>
                </div>
            </div> <!-- card --> 
        @endif
        @if(is_route(['job.category.edit', $job->id,'category'=>'type']))
           
            <div class="card">
                <div class="card-header">募集職種を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach(App\Models\TypeCat::all() as $typeCat)
                        <div class="e-radio-item02">
                            <input id="type_cat_id_{{$typeCat->id}}" class="" type="radio" name="type_cat_id" @if(Session::has('data.form.edit_category.type')) {{Session::get('data.form.edit_category.type') == $typeCat->id ? 'checked' : ''}}@else {{$job->type_cat_id == $typeCat->id ? 'checked' : ''}} @endif value="{{ $typeCat->id }}">
                            <label for="type_cat_id_{{$typeCat->id}}">{{ $typeCat->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- card --> 
        @endif
        @if(is_route(['job.category.edit', $job->id,'category'=>'area']))
            <div class="card">
                <div class="card-header">勤務地エリアを選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach(App\Models\AreaCat::all() as $areaCat)
                        <div class="e-radio-item02">
                            <input id="area_cat_id_{{$areaCat->id}}" class="" type="radio" name="area_cat_id" @if(Session::has('data.form.edit_category.area')) {{Session::get('data.form.edit_category.area') == $areaCat->id ? 'checked' : ''}}@else {{$job->area_cat_id == $areaCat->id ? 'checked' : ''}} @endif value="{{ $areaCat->id }}">
                            <label for="area_cat_id_{{$areaCat->id}}">{{ $areaCat->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- card --> 
        @endif
        @if(is_route(['job.category.edit', $job->id,'category'=>'hourly_salary']))
            <div class="card">
                <div class="card-header">最低時給を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach(App\Models\HourlySalaryCat::all() as $hourlySalaryCat)
                        <div class="e-radio-item02">
                            <input id="hourly_salary_cat_id_{{$hourlySalaryCat->id}}" class="" type="radio" name="hourly_salary_cat_id" @if(Session::has('data.form.edit_category.hourly_salary')) {{Session::get('data.form.edit_category.hourly_salary') == $hourlySalaryCat->id ? 'checked' : ''}}@else {{$job->hourly_salary_cat_id == $hourlySalaryCat->id ? 'checked' : ''}} @endif value="{{ $hourlySalaryCat->id }}">
                            <label for="hourly_salary_cat_id_{{$hourlySalaryCat->id}}">{{ $hourlySalaryCat->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <!-- card --> 
        @endif
        @if(is_route(['job.category.edit', $job->id,'category'=>'date']))
    
            <div class="card">
                <div class="card-header">最低勤務日数を選んでください<span class="text-danger">＊</span></div>
                <div class="card-body">
                     <p class="mb-3">※ひとつだけ選択できます</p>
                    <div class="form-group e-radioform e-radioform02">
                        @foreach(App\Models\DateCat::all() as $dateCat)
                        <div class="e-radio-item02">
                            <input id="date_cat_id_{{$dateCat->id}}" class="" type="radio" name="date_cat_id" @if(Session::has('data.form.edit_category.date')) {{Session::get('data.form.edit_category.date') == $dateCat->id ? 'checked' : ''}}@else {{$job->date_cat_id == $dateCat->id ? 'checked' : ''}} @endif value="{{ $dateCat->id }}">
                            <label for="date_cat_id_{{$dateCat->id}}">{{ $dateCat->name }}</label>
                        </div>
                        @endforeach
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


