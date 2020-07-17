<!-- adminlte::pageを継承 -->
@extends('adminlte::page')

<!-- ページタイトルを入力 -->
@section('title', '管理画面')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1 style="display:inline-block">{{$catTitle}}カテゴリ</h1>
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

            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#categoryModal">
                登録
            </button><br>

        
            @if (count($arrCatList) > 0)
            <br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        @if($url === 'salary')
                        <th width="120px">親カテゴリ</th>
                        @endif
                        <th width="120px">カテゴリID</th>
                        <th>カテゴリ名</th>
                        <th width="60px">編集</th>
                    </tr>
                </thead>
                @if($url === 'salary')
                    @foreach ($arrCatList as $category)
                    <tbody>
                        <tr data-category_id="{{ $category['id'] }}">
                            <td>
                                <span class="name">{{ $category['name'] }}</span>
                            </td>
                        </tr>
                        @foreach ($category['children'] as $cat)
                        <tr data-category_id="{{ $cat['id'] }}">
                            <td></td>
                            <td>
                                <span class="id">{{ $cat['id'] }}</span>
                            </td>
                            <td>
                                <span class="name">{{ $cat['name'] }}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#categoryModal" data-category_id="{{ $cat['id'] }}">編集</button>
                            </td>
                        </tr>
                        @endforeach
                        <input type="hidden" class="parent_id" value="{{$category['id']}}">
                    </tbody>
                    @endforeach
                @else
                    <tbody>
                    @foreach ($arrCatList as $category)
                        <tr data-category_id="{{ $category['id'] }}">
                            <td>
                                <span class="id">{{ $category['id'] }}</span>
                            </td>
                            <td>
                                <span class="name">{{ $category['name'] }}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#categoryModal" data-category_id="{{ $category['id'] }}">編集</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <input type="hidden" class="parent_id" value="{{$arrCatList[0]['parent_id']}}">
                @endif
            </table>

            @else
            <br>
            <p>カテゴリがありません。</p>
            @endif

             <!-- モーダル・ダイアログ -->
            <div class="modal fade" id="categoryModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span>×</span>
                            </button>
                            <h4 class="modal-title">カテゴリ編集</h4>
                        </div>

                        <div class="modal-body">
                            {{--API 通信結果表示部分--}}
                            <div id="api_result" class="hidden"></div>

                            <form class="form-horizontal">
                                @if($url === 'salary')
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">親カテゴリ</label>
                                    <div class="col-sm-10">
                                        <select name="pId" class="pId">
                                            @foreach ($arrCatList as $category)
                                            <option value="{{$category['id']}}">{{$category['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">カテゴリ名</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" placeholder="カテゴリ名">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                            <button type="button" id="category_delete" class="btn btn-danger">削除</button>
                            <button type="button" id="category_submit" class="btn btn-primary" >保存</button>
                            <input type="hidden" name="category_id">
                            <input type="hidden" name="flag" value="{{$url}}">
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
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

<!-- 読み込ませるJSを入力 -->
@section('js')
<script>
    $(function() {
        $('a').click(function() {
            $(this).click(function () {
                alert('只今処理中です。\nそのままお待ちください。');
                return false;
            });
        });
    });
</script>
 <script src="{{ asset('js/category.js') }}"></script>
@stop