<!-- adminlte::pageを継承 -->
@extends('adminlte::page')
<!-- ページタイトルを入力 -->
@section('title', 'JOB CiNEMA | ダッシュボード')

<!-- ページの見出しを入力 -->
@section('content_header')
<h1><i class="fas fa-home mr-2"></i>ダッシュボード</h1>
@stop

<!-- ページの内容を入力 -->
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">未読メール<span class="ml-3">５件</span></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>日時</th>
                                <th>件名</th>
                                <th>タイプ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>2020-05-04 20:40</td>
                                <td><span class="badge badge-success">システム不具合</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">求職者</div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>2020-05-04 20:40</td>
                                <td><span class="badge badge-success">システム不具合</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">求職者</div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>2020-05-04 20:40</td>
                                <td><span class="badge badge-success">システム不具合</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">求職者</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">全ての未読メールをみる</a>
            </div>
        </div>
    </div>
</div>
@stop

<!-- 読み込ませるCSSを入力 -->
<!-- @section('css')
@stop -->

<!-- 読み込ませるJSを入力 -->
@section('js')

@stop
