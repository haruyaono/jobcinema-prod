<div class="main-section-item newjob-entry">
  <h2 class="txt-h2 top-heading-h2"><i class="fas fa-map-marker-alt font-yellow mr-2"></i>エリアからアルバイトを探す</h2>

  <div class="top-category-wrap">
    <ul class="top-category-list">
      @foreach($categories->where('slug', 'area')->first()->children->sortBy('sort') as $cat)
      <li class="top-category-list-item">
        <a href="{{url('job_sheet/search/all?area=' . $cat->id)}}" class="h-100 feature-item">
          {{$cat->name}}
        </a>
      </li>
      @endforeach
    </ul>
  </div>
</div>
