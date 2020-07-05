
<section class="search-section">
  <div class="inner">
      <form id="composite-form" method="get" action="{{route('alljobs')}}" role="form">
        @foreach($categoryList as $itemIndex => $categoryItem) 
        <div class="composite composite-{{$itemIndex}}">
          <div class="composite-left">
            <p>{{$categoryItem->name}}<span class="ib-only-pc">で探す</span></p>
          </div>
          <div class="composite-right">
            <div class="select-wrap">
              <select id="search-{{$categoryItem->slug}}" class="selectbox" name="{{$categoryItem->slug}}_cat_id" data-toggle="select">
                <option value="">-選択-</option>
                @foreach($categoryItem->children as $cIndex => $cat)
                  <option value="{{ $cat->id }}" {{ ( old($categoryItem->slug .'_cat_id') == $cat->id ) ? 'selected' : '' }} @if(isset(${$categoryItem->slug}) && ${$categoryItem->slug} == $cat->id) selected @endif>{{ $cat->name }}</option>
                @endforeach
              </select>
              @foreach($categoryItem->children as $cIndex => $cat)
                @if($cat->children->count() !== 0)
                <select id="search-status" class="selectbox" name="{{$cat->slug}}" data-toggle="select">
                  <option value="">-選択-</option>
                  @foreach($cat->children as $cCIndex => $cCat)
                    <option value="{{ $cCat->id }}" >{{ $cCat->name }}</option>
                  @endforeach
                </select>
                @endif
              @endforeach
            </div>
          </div>
        </div>
        @endforeach
        <div class="composite mb-3 composite-6">
          <div class="composite-left">
           <p>キーワード</p>
          </div>

          <div class="composite-right">
            <input id="search-text" type="text" name="title" style="height:40px; padding: 3px 6px; width: 100%;" placeholder="例）コンビニ" value="@if(old('title')){{ old('title') }} @elseif(!old('title') && isset($keyword)){{$keyword}}@endif">  
          </div>
        </div>

        <p class="job-count">検索結果 <span id="job-count">{{isset($jobCount) ? $jobCount : 0}}</span>件</p>

        <button type="submit" id="filter-search"><i class="fas fa-search"></i>絞り込み検索</button>
      </form>

  </div> <!-- inner -->
</section> <!-- search-section -->
