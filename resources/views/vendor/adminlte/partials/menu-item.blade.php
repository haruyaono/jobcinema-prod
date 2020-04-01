@if (is_string($item))
    <li class="header">{{ $item }}</li>
@elseif (isset($item['header']))
    <li class="header">{{ $item['header'] }}</li>
@elseif (isset($item['search']) && $item['search'])
    <form action="{{ $item['href'] }}" method="{{ $item['method'] }}" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="{{ $item['input_name'] }}" class="form-control" placeholder="
            {{ $item['text'] }}
          ">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fas fa-search"></i>
                </button>
              </span>
        </div>
      </form>
@else
    <li class="{{ $item['class'] }}">
        <a href="{{ $item['href'] }}"
           @if (isset($item['target'])) target="{{ $item['target'] }}" @endif
        >
            <span>
                {{ $item['text'] }}
            </span>

            @if($item['text'] == '承認待ち')
            <span class="pull-right-container">
                <span class="label label-{{ $item['label_color'] ?? 'primary' }} pull-right">
                        {{App\models\JobItem::where('status', 1)->count()}}
                </span>
            </span>
            @endif
            @if($item['text'] == 'お祝い金申請中')
            <span class="pull-right-container">
                <span class="label label-{{ $item['label_color'] ?? 'primary' }} pull-right">
                        {{\DB::table('job_item_user')->whereNotNull('oiwaikin')->whereNotNull('first_attendance')->count()}}
                </span>
            </span>
            @endif
        </a>
    </li>
    
@endif
