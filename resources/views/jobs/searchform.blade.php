
<section class="search-section">
  <div class="inner">
      <form id="composite-form" method="get" action="{{route('alljobs')}}" role="form" class="cf">
        @foreach($categoryList as $itemIndex => $categoryItem) 
        <div class="composite composite-{{$itemIndex}}">
          <div class="composite-left">
            <p>{{$categoryItem->name}}<span class="ib-only-pc">で探す</span></p>
          </div>
          <div class="composite-right">
            <div class="select-wrap select-wrap-{{$categoryItem->slug}}">
              <select id="search-{{$categoryItem->slug}}" class="selectbox" name="{{$categoryItem->slug}}" data-toggle="select">
                <option value="">選択してください</option>
                @foreach($categoryItem->children as $cIndex => $cat)
                  <option value="{{ $cat->id }}" {{ ( old($categoryItem->slug) == $cat->id ) ? 'selected' : '' }} @if(isset($searchParam[$categoryItem->slug]) && $searchParam[$categoryItem->slug] == $cat->id) selected @endif>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            @if($categoryItem->slug == 'salary')
            <div class="option-lst jsc-option-lst jsc-option-required-wrapper select-wrap"> 
                <select class="jsc-not-select selectbox" disabled="disabled">
                  <option value="">指定なし</option>
                </select>
              @foreach($categoryItem->children as $cIndex => $cat)
                @if($cat->children->count() !== 0)
                <select id="search-{{$cat->slug}}" class="selectbox search-{{$categoryItem->slug}}-child" name="{{$cat->slug}}" data-toggle="select" data-val="{{$cat->id}}">
                  <option value="">指定なし</option>
                  @foreach($cat->children as $cCIndex => $cCat)
                    <option value="{{ $cCat->id }}" {{ ( old($cat->slug) == $cCat->id ) ? 'selected' : '' }} @if(isset($searchParam[$cat->slug]) && $searchParam[$cat->slug] == $cCat->id) selected @endif>{{ $cCat->name }}</option>
                  @endforeach
                </select>
                @endif
              @endforeach
            </div>
            @endif
          </div>
        </div>
        @endforeach
        <div class="composite mb-3 composite-5">
          <div class="composite-left">
           <p>キーワード</p>
          </div>

          <div class="composite-right">
            <input id="search-text" type="text" name="keyword" style="height:35px; padding: 4px 6px; width: 100%;" placeholder="例）コンビニ" value="@if(old('keyword')){{ old('keyword') }} @elseif(!old('keyword') && isset($searchParam['keyword'])){{$searchParam['keyword']}}@endif">  
          </div>
        </div>

        <p class="job-count">検索結果 <span id="job-count">{{isset($jobCount) ? $jobCount : 0}}</span>件</p>

        <button type="button" id="filter-search" @click="search()"><i class="fas fa-search" ></i>絞り込み検索</button>
      </form>

  </div> <!-- inner -->
</section> <!-- search-section -->
