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
    @elseif($url == 'hourly_salary')
    時給から探す
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
                    @foreach($typeCats as $typeCat)
                        <li><i class="far fa-caret-square-right"></i><a href="{{route('type.cat.get', [$typeCat->id])}}">{{$typeCat->name}}</a></li>
                    @endforeach
                    </ul>
                </div>
            @elseif($url == 'area')
                <h1 class="c-title"><i class="fas fa-map-marker-alt font-yellow mr-2"></i>求人をエリアから探す</h1>
                <div class="c-box clearfix">
                    <ul class="c-list">
                    @foreach($areaCats as $areaCat)
                        <li><i class="far fa-caret-square-right"></i><a href="{{route('area.cat.get', [$areaCat->id])}}">{{$areaCat->name}}</a></li>
                    @endforeach
                    </ul>
                </div>
            @elseif($url == 'hourly_salary')
                <h1 class="c-title"><i class="fas fa-money-bill-wave font-yellow mr-2"></i>求人を時給から探す</h1>
                <div class="c-box clearfix">
                    <ul class="c-list">
                    @foreach($hourlySalaryCats as $hourlySalaryCat)
                        <li><i class="far fa-caret-square-right"></i><a href="{{route('hourly.salary.cat.get', [$hourlySalaryCat->id])}}">{{$hourlySalaryCat->name}}</a></li>
                    @endforeach
                    </ul>
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