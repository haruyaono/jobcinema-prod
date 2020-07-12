
<div class="main-section-item newjob-entry">
    <h2 class="txt-h2 top-heading-h2"><i class="far fa-list-alt font-yellow mr-2"></i>職種からアルバイトを探す</h2>
    
    <div class="top-category-wrap">
      <ul class="top-category-list">
      @foreach($categoryList[1]->children as $cat)
        <li class="top-category-list-item">
          <a href="{{url('jobs/search/all?type=' . $cat->id)}}" class="h-100 feature-item">
           {{$cat->name}}
          </a>
        </li>
      @endforeach
      </ul>
    </div>
</div>