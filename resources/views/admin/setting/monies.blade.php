<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">
    @if($flag === 'congrats')
    お祝い金の設定
    @else
    採用単価の設定
    @endif
</h1>
<span><a href="{{route('admin_category.top')}}" style="margin-left:10px;">Back</a></span>

@if(Session::has('message'))
<div class="alert alert-success" style="margin-top:15px;">{{Session::get('message')}}</div>
@endif
@stop

<!-- ページの内容を入力 -->
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            @if ($moniesList->count() > 0)
            <br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="120px">
                            @if($flag === 'congrats')
                            お祝い金ID
                            @else
                            採用単価ID
                            @endif
                        </th>
                        <th>金額</th>
                        <th>対象</th>
                        <th>ラベル</th>
                        <th width="60px">編集</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($moniesList as $moniesItem)
                    <tr data-target_id="{{ $moniesItem->id }}">
                        <td>
                            <span>{{ $moniesItem->id }}</span>
                        </td>
                        <td>
                            <span class="amount">{{ number_format($moniesItem->amount) }}円</span>
                        </td>
                        <td>
                            <span class="category-name">{{ $moniesItem->category->name }}</span>
                        </td>
                        <td>
                            <span class="label-name">{{ $moniesItem->label }}</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#adminModal" data-target_id="{{ $moniesItem->id }}" data-target_amount="{{ $moniesItem->amount }}">編集</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <br>
            <p>採用単価・お祝い金は、[システム設定→求人カテゴリ→雇用形態カテゴリ→登録or削除]で自動登録・削除されます。</p>
            <a href="{{route('admin_category', ['flag' => 'status'])}}">設定する</a>
            @endif

            <!-- モーダル・ダイアログ -->
            <div class=" modal fade" id="adminModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span>×</span>
                            </button>
                            <h4 class="modal-title">
                                @if ($flag === 'congrats')
                                お祝い金 編集
                                @else
                                採用単価 編集
                                @endif
                            </h4>
                        </div>

                        <div class="modal-body">
                            {{--API 通信結果表示部分--}}
                            <div id=" api_result" class="hidden">
                            </div>

                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">雇用形態</label>
                                    <div class="col-sm-10">
                                        <p class="target_category_text mt-1 mb-0"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">金額</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="amount" class="form-control" placeholder="金額">
                                    </div>
                                    <div class="col-sm-1">
                                        <p class="mt-2 mb-0">円</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ラベル</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="label" class="form-control" placeholder="任意の識別名">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                            <button type="button" id="target_submit" class="btn btn-primary">保存</button>
                            <input type="hidden" name="target_id">
                            <input type="hidden" name="flag" value="{{$flag}}">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

<!-- 読み込ませるCSSを入力 -->
@section('css')

@stop

<!-- 読み込ませるJSを入力 -->
@section('js')
<script src="{{ asset('js/admin_system.js') }}"></script>
@stop
