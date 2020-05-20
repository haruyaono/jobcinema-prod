
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
                @foreach(App\Job\Categories\StatusCategory::all() as $statusCategory)
                <option value="{{ $statusCategory->id }}" {{ ( old('status_cat_id') == $statusCategory->id ) ? 'selected' : '' }} @if(isset($status) && $status == $statusCategory->id) selected @endif>{{ $statusCategory->name }}</option>
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
                @foreach(App\Job\Categories\TypeCategory::all() as $typeCategory)
                <option  value="{{ $typeCategory->id }}" {{ ( old('type_cat_id') == $typeCategory->id ) ? 'selected' : '' }} @if(isset($type) && $type == $typeCategory->id) selected @endif>{{ $typeCategory->name }}</option>
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
                <select id="search-area" class="selectbox areaSelect" name="area_cat_id" data-toggle="select">
                <option value="">-選択-</option>
                @foreach(App\Job\Categories\AreaCategory::all() as $areaCategory)
                <option  value="{{ $areaCategory->id }}" {{ ( old('area_cat_id') == $areaCategory->id ) ? 'selected' : '' }} @if(isset($area) && $area == $areaCategory->id) selected @endif>{{ $areaCategory->name }}</option>
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
                @foreach(App\Job\Categories\HourlySalaryCategory::all() as $hourlySalaryCategory)
                <option  value="{{ $hourlySalaryCategory->id }}"  {{ ( old('hourly_salary_cat_id') == $hourlySalaryCategory->id ) ? 'selected' : '' }} @if(isset($hourlySaraly) && $hourlySaraly == $hourlySalaryCategory->id) selected @endif>{{ $hourlySalaryCategory->name }}</option>
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
                @foreach(App\Job\Categories\DateCategory::all() as $dateCategory)
                <option  value="{{ $dateCategory->id }}" {{ ( old('date_cat_id') == $dateCategory->id ) ? 'selected' : '' }} @if(isset($date) && $date == $dateCategory->id) selected @endif>{{ $dateCategory->name }}</option>
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

        <p class="job-count">検索結果 <span id="job-count">{{isset($jobCount) ? $jobCount : 0}}</span>件</p>

        <button type="submit" id="filter-search"><i class="fas fa-search"></i>絞り込み検索</button>
      </form>

  </div> <!-- inner -->
</section> <!-- search-section -->
