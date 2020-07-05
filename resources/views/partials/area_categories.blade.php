
<div class="main-section-item newjob-entry">
    <h2 class="txt-h2 top-heading-h2"><i class="fas fa-map-marker-alt font-yellow mr-2"></i>エリアからアルバイトを探す</h2>
    
    <div class="top-category-wrap">
      <ul class="top-category-list">
      @foreach($categoryList[2]->children as $cat)
        <li class="top-category-list-item">
          <a href="{{url('jobs/search/all?area_cat_id=' . $cat->id)}}" class="h-100 feature-item">
           {{$cat->name}}
          </a>
        </li>
      @endforeach
      </ul>
    </div>
</div>