@extends('layouts.master')

@section('title', $hourlySalaryCatArchive->name . 'の求人情報 | JOB CiNEMA')
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
    <a>
    {{$hourlySalaryCatArchive->name}}の求人情報
    </a>
  </li>
</ol>
</div>
<!-- ここからメインコンテンツ -->
<div class="main-wrap">
	<!-- 絞り込み・検索エリア -->
	@include('jobs.searchform')

	<!-- カスタム投稿の新着案件 10件 -->
	<section class="main-section job-entry-section">
		<div class="inner">
			<div class="pad">
                <h1 class="txt-h1">{{$hourlySalaryCatArchive->name}}のアルバイト求人情報</h1>
          <div class="d-flex mb-3">
           <p class="search-count"><span class=" mr-1">{{ $jobs->count() }}</span>求人 <span>{{ $jobs->firstItem() }}件 〜 {{ $jobs->lastItem() }}件を表示</span></p>
         </div>


				<div class="job-list">
					<!-- ▽ ループ開始 ▽ -->
          @if ($jobs->count() > 0 )
          @foreach ($jobs as $job)
					<div class="job-item">
						<a href="{{ route('jobs.show', [$job->id, $job->slug])}}" class="job-item-link">
              <div class="job-item-heading only-pc">
								<!-- カテゴリ -->
                 <span class="cat-item org">{{ optional($job->type_cat_get)->name}}</span>
                 <span class="cat-item red">{{ optional($job->status_cat_get)->name}}</span>
              </div>
							<div class="title-img-wrap">
              <div class="job-left only-sp">
								@if(($job->job_img) ==! null)
									<img src="{{$job->job_img}}" alt=""/>
									@endif
								</div>
								<h2 class="txt-h2">
									{{$job->job_title}}
									<p class="company_name_item">{{$job->company->cname}}</p>
								</h2>
                
							</div>

              <div class="d-flex">
                <div class="job-left only-pc">
                  @if(($job->job_img) ==! null)
                  <img src="{{$job->job_img}}" style="width:100%;" alt=""/>
                  @else
                  <img src="{{ asset('uploads/images/no-image.gif')}}" style="width:100%;" alt="No image">
                  @endif
                </div>
                <div class="job-right">
                  <table class="job-table">
                    <tr>
                      <th><span class="money"><span>給与</span></span></th>
                      <td>{{ str_limit($job->job_hourly_salary, $limit = 40, $end = '...')}}</td>
                    </tr>
                    <tr>
                      <th><span class="place"><span>勤務先</span></span></th>
                      <td>{{ str_limit($job->job_office, $limit = 40, $end = '...')}}</td>
                    </tr>
										<tr>
											<th><span class="work"><span>仕事内容</span></span></th>
											<td>{{ str_limit($job->job_desc, $limit = 80, $end = '...')}}</td>
										</tr>
                    <tr>
                      <th><span class="time"><span>勤務時間</span></span></th>
                      <td>{{ str_limit($job->job_time, $limit = 40, $end = '...')}}</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- <div class="jobitem-footer" @if(!$job->pubend_at) style="display:block; text-align:right;" @endif>
                @if($job->pubend_at)
                <span>{{ $job->pubend_at->format('Y年m月d日') }}に掲載終了</span>
                @endif
                <object>
                  <a href="{{ route('jobs.show', [$job->id, $job->slug])}}" class="btn detail-btn"><span>詳しく見る</span></a>
                </object>
              </div> -->
						</a>
					</div> <!-- newjob-item -->
					<!-- △ ループ終了 △ -->
				@endforeach
        @else
          <p>条件にマッチする求人がありません。</p>
        @endif
				</div> <!-- newjob-list -->
			</div> <!-- pad -->
      <div class="paginate text-center">
      {{ $jobs->appends(Illuminate\Support\Facades\Input::except('page'))->links()}}
      </div>
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