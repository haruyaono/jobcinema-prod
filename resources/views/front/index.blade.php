@extends('layouts.master')

@section('title', 'JOB CiNEMA')
@section('description', '釧路の職場を上映する求人サイト')

@section('header')
@component('components.header')
@endcomponent
@endsection

@section('contents')
<div class="main-slider-wrap">
	<slick-top
		v-bind:ad-items='{{ $adItems }}'
	></slick-top>
</div>
<div class="main-default-ad">
	<div class="ad_item">
		<a href="/beginners">
			<img class="ad_def_img" src="/img/common/jobcinema_hedd_sam4_aのコピー.png" alt="JOBCiNEMAとは"/>
		</a>
	</div>
	<div class="ad_item center">
		<a href="/lp">
			<img class="ad_def_img" src="/img/common/jobcinema_hedd_sam5_aのコピー.png" alt="広告掲載企業募集について"/>
		</a>
	</div>
	<div class="ad_item">
		<a href="/reward_request">
			<img class="ad_def_img" src="/img/common/jobcinema_hedd_sam6_aのコピー.png" alt="お祝い金申請について"/>
		</a>
	</div>
</div>
<div class="main-wrap">
	<div class="only-pc">
		<search-component></search-component>
	</div>
	<section class="main-section">
		<div class="inner">
			<div class="pad">
				<div class="main-section-item newjob-entry">
					<h2 class="txt-h2 top-heading-h2 mt-0"><i class="far fa-clock font-yellow mr-2 h4"></i>釧路の新着求人</h2>
					<div class="newjob-list-border">
						<div class="newjob-list">
							@forelse ($topNewJobs as $jobitem)
							<div class="newjob-item">
								<a href="{{ route('show.front.job_sheet.detail', $jobitem) }}" class="newjob-item-link">
									<p class="joblist_jobCassette__image_wrap">
										@if($jobitem->job_img_1)
										<img src="{{ config('app.s3_url') . config('jobcinema.jobitem_image_dir') . $jobitem->job_img_1 }}" style="width:100%;" alt="" />
										@else
										<img src="{{ asset('img/common/no-image.gif')}}" style="width:100%;" alt="No image">
										@endif
									</p>
									<div class="txt-wrap">
										<h3 class="txt-h3">
											{{$jobitem->company->cname}}
										</h3>
										<div class="job-desc-list">
											<p><span class="occupation"><span>{{ str_limit($jobitem->job_type, $limit = 40, $end = '...')}}</p>
											<p><span class="money"><span>{{ str_limit($jobitem->job_salary, $limit = 40, $end = '...')}}</p>
											<p><span class="place"><span>{{ str_limit($jobitem->job_office_address, $limit = 40, $end = '...')}}</p>
										</div>
									</div>

								</a>
							</div>
							@empty
							<p class="my-3">新着案件がありません。</p>
							@endforelse
						</div>
						<p class="more-link">
							<a href="{{ route('index.front.job_sheet.search') }}">求人一覧を見る</a>
						</p>
					</div>
				</div>

				@include('partials.type_categories')
				@include('partials.area_categories')

				@if(!Auth::guard('seeker')->check())
				<div class="main-section-item top-subsection-item only-sp" sty>
					<div class="top-sp-auth-btn-wrap">
						<p><a class="btn btn-yellow w-100 mb-3" href="{{ route('seeker.register') }}">会員登録</a></p>
						<p><a class="btn btn-outline-secondary w-100" href="{{ route('seeker.login') }}">ログイン</a></p>
					</div>
				</div>
				@endif

				<recent-component></recent-component>

				@include('partials.description')
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
<script type="text/javascript" refer>
	$(function() {
		$(".wide-notice-overlay").show();
		Cookies.get('btnFlg') == 'on' ? $(".wide-notice-overlay").hide() : $(".wide-notice-overlay").show();
		$(".notice-close").click(function() {
			$(".wide-notice-overlay").fadeOut();
			Cookies.set('btnFlg', 'on', {
				expires: 30,
				path: '/'
			}); //cookieの保存
		});
	});
</script>
@endsection
