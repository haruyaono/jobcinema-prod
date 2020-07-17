@extends('layouts.master')

@section('title', 'カテゴリ | JOB CiNEMA')
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
    <a href="/">
      <i class="fa fa-home"></i><span>釧路の求人情報TOP</span>
    </a>
  </li>
  <li>
    @if($url == 'type')
    職種から探す
    @elseif($url == 'area')
    エリアから探す
    @elseif($url == 'salary')
    給与から探す
    @endif
  </li>
</ol>
</div>
<div class="main-wrap">

	<section class="main-section cat-list-section">
		<div class="inner">
			<div class="pad">
			@if($url == 'type')
                <h1 class="c-title"><i class="far fa-list-alt font-yellow mr-2"></i>求人を職種から探す</h1>
                <div class="c-box clearfix">
                    <ul class="c-list">
                    @foreach($categories->where('slug', 'type')->first()->children->sortBy('id') as $category)
                        <li><i class="far fa-caret-square-right"></i><a href="{{url('jobs/search/all?type=' . $category->id)}}" class="txt-blue-link">{{$category->name}}</a></li>
                    @endforeach
                    </ul>
                </div>
            @elseif($url == 'area')
                <h1 class="c-title"><i class="fas fa-map-marker-alt font-yellow mr-2"></i>求人をエリアから探す</h1>
                <div class="c-box clearfix">
                    <ul class="c-list">
                    @foreach($categories->where('slug', 'area')->first()->children->sortBy('id') as $category)
                        <li><i class="far fa-caret-square-right"></i><a href="{{url('jobs/search/all?area=' . $category->id)}}" class="txt-blue-link">{{$category->name}}</a></li>
                    @endforeach
                    </ul>
                </div>
            @elseif($url == 'salary')
                <h1 class="c-title"><i class="fas fa-money-bill-wave font-yellow mr-2"></i>求人を時給から探す</h1>
                <div class="c-box clearfix">
                    @foreach($categories->where('slug', 'salary')->first()->children->sortBy('id') as $category)
                        <div class="mb-3 cf">
                        <p class="h5"><i class="far fa-caret-square-right"></i>{{$category->name}}</p>
                          <ul class="c-list">
                            @foreach($category->children->sortBy('id') as $cat)
                              <li><a href="{{url('jobs/search/all?salary=' . $category->id. '&' . $category->slug. '=' . $cat->id)}}" class="txt-blue-link">{{$cat->name}}</a></li>
                            @endforeach
                          </ul>
                        </div>
                    @endforeach
                </div>
            @endif
				
			</div> <!-- pad -->
		</div> <!-- inner -->
	</section> <!-- newjob-entry -->

	


</div> <!-- main-wrap-->
@endsection

@section('footer')
  @component('components.footer')
  @endcomponent
@endsection

@section('js')
  <script src="{{ asset('js/main.js') }}"></script>
@endsection