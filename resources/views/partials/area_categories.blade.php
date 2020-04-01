
<div class="main-section-item newjob-entry">
    <h2 class="txt-h2 top-heading-h2"><i class="fas fa-map-marker-alt font-yellow mr-2"></i>エリアからアルバイトを探す</h2>
    
    <div class="top-category-wrap">
      <ul class="top-category-list">
      @foreach(App\Models\AreaCat::all() as $areaCategory)
        <li class="top-category-list-item">
          <a href="{{route('area.cat.get', [$areaCategory->id])}}" class="h-100 feature-item">
           {{$areaCategory->name}}
          </a>
        </li>
      @endforeach
      </ul>
    </div>
</div>