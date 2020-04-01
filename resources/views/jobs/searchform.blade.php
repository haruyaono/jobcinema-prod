
<section class="search-section">
  <div class="inner">
      <form id="composite-form" method="get" action="{{route('alljobs')}}" role="form">
        <div class="composite composite-1">
          <div class="composite-left">
            <p>雇用形態<span class="ib-only-pc">で探す</span></p>
          </div>

          <div class="composite-right">
            <div class="select-wrap">
                <select id="search-status" class="selectbox" name="status_cat_id" data-toggle="select">
                <option value="">-選択-</option>
                @foreach(App\Models\StatusCat::all() as $statusCat)
                <option  value="{{ $statusCat->id }}" {{ ( old('status_cat_id') == $statusCat->id ) ? 'selected' : '' }} @if(isset($status) && $status == $statusCat->id) selected @endif>{{ $statusCat->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="composite composite-2">
          <div class="composite-left">
            <p>職種<span class="ib-only-pc">で探す</span></p>
          </div>

          <div class="composite-right">
            <div class="select-wrap">
                <select id="search-type" class="selectbox" name="type_cat_id" data-toggle="select">
                <option value="">-選択-</option>
                @foreach(App\Models\TypeCat::all() as $typeCat)
                <option  value="{{ $typeCat->id }}" @if(old('type_cat_id') == $typeCat->id)selected @elseif(!old('type_cat_id') && isset($typeCatArchive) && $typeCat->id == $typeCatArchive->id)selected @elseif(!old('type_cat_id') && !isset($typeCatArchive) && isset($type) && $type == $typeCat->id) selected @endif>{{ $typeCat->name }}</option>
                @endforeach
                </select>
            </div>
          </div>
        </div>
        <div class="composite composite-3">
          <div class="composite-left">
            <p>エリア<span class="ib-only-pc">で探す</span></p>
          </div>

          <div class="composite-right">
            <div class="select-wrap">
                <select id="search-area" class="selectbox" name="area_cat_id" data-toggle="select">
                <option value="">-選択-</option>
                @foreach(App\Models\AreaCat::all() as $areaCat)
                <option  value="{{ $areaCat->id }}" @if(old('area_cat_id') == $areaCat->id)selected @elseif(!old('area_cat_id') && isset($areaCatArchive) && $areaCat->id == $areaCatArchive->id)selected @elseif(!old('area_cat_id') && !isset($areaCatArchive) && isset($area) && $area == $areaCat->id) selected @endif>{{ $areaCat->name }}</option>
                @endforeach
                </select> 
            </div>
          </div>
        </div>
        <div class="composite composite-4">
          <div class="composite-left">
            <p>時給<span class="ib-only-pc">で探す</span></p>
          </div>

          <div class="composite-right">
            <div class="select-wrap">
                <select id="search-hourly-salary" class="selectbox" name="hourly_salary_cat_id" data-toggle="select">
                <option value="">-選択-</option>
                @foreach(App\Models\HourlySalaryCat::all() as $hourlySalaryCat)
                <option  value="{{ $hourlySalaryCat->id }}" @if(old('hourly_salary_cat_id') == $hourlySalaryCat->id)selected @elseif(!old('hourly_salary_cat_id') && isset($hourlySalaryCatArchive) && $hourlySalaryCat->id == $hourlySalaryCatArchive->id)selected @endif>{{ $hourlySalaryCat->name }}</option>
                @endforeach
                </select>
            </div>
          </div>
        </div>
        <div class="composite composite-5">
          <div class="composite-left">
            <p>勤務日数<span class="ib-only-pc">で探す</span></p>
          </div>

          <div class="composite-right">
            <div class="select-wrap">
                <select id="search-date" class="selectbox" name="date_cat_id" data-toggle="select">
                <option value="">-選択-</option>
                @foreach(App\Models\DateCat::all() as $dateCat)
                <option  value="{{ $dateCat->id }}" {{ ( old('date_cat_id') == $dateCat->id ) ? 'selected' : '' }}>{{ $dateCat->name }}</option>
                @endforeach
                </select>
            </div>
          </div>
        </div>
        <div class="composite mb-3 composite-6">
          <div class="composite-left">
           <p>キーワード</p>
          </div>

          <div class="composite-right">
            <input id="search-text" type="text" name="title" style="height:40px; padding: 3px 6px; width: 100%;" placeholder="例）コンビニ" value="@if(old('title')){{ old('title') }} @elseif(!old('title') && isset($keyword)){{$keyword}}@endif">  
          </div>
        </div>

        <p class="job-count">検索結果 <span id="job-count">{{$jobs->count()}}</span>件</p>

        <button type="submit" id="filter-search"><i class="fas fa-search"></i>絞り込み検索</button>
      </form>

  </div> <!-- inner -->
</section> <!-- search-section -->
