
<div class="main-section-item newjob-entry">
    <h2 class="txt-h2 top-heading-h2"><i class="far fa-list-alt font-yellow mr-2"></i>職種からアルバイトを探す</h2>
    
    <div class="top-category-wrap">
      <ul class="top-category-list">
      @foreach(App\Job\Categories\TypeCategory::all() as $typeCategory)
        <li class="top-category-list-item">
          <a href="{{url('jobs/search/all?type_cat_id=' . $typeCategory->id)}}" class="h-100 feature-item">
           {{$typeCategory->name}}
          </a>
        </li>
      @endforeach
      </ul>
    </div>
</div>