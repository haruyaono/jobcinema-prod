@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 広告管理')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>広告管理</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item"><a href="{{ route('ad_item.index') }}">広告管理</a></li>
    <li class="breadcrumb-item active">新規</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">作成</h3>
                    <div class="card-tools">
                        <div class="btn-group" style="margin-right: 5px">
                            <a href="{{ route('ad_item.index') }}" class="btn btn-sm btn-default" title="一覧">
                                <i class="fa fa-list"></i><span class="hidden-xs"> 一覧</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('ad_item.store') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong><i class="fas fa-exclamation-circle"></i>エラー</strong><br>
                                <ul class="list-unstyled">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="body-box">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">広告掲載元</label>
                                    <div class="col-sm-8">
                                        <div>
                                            <select id="select_company" class="custom-select parent" name="data[AdItem][company_id]" required onchange="getJobItem(this)">
                                                <option value="">掲載企業の選択</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->cname }}</option>
                                                @endforeach
                                            </select>
                                            <select id="job_item" class="custom-select mt-2 children" name="data[AdItem][job_item_id]" required disabled>
                                                <option value="">掲載広告の選択</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">画像ファイル</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="file" accept="image/jpeg,image/png" class="form-control" name="data[AdItem][image]" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">説明</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="description" class="form-control" placeholder="入力　説明" name="data[AdItem][description]" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">料金</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="number" id="description" class="form-control" placeholder="入力　料金" name="data[AdItem][price]" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">掲載</label>
                                    <div class="col-1">
                                        <div class="input-group">
                                            <input name="data[AdItem][is_view]" type="hidden" value="0">
                                            <input type="checkbox" id="description" class="form-control" placeholder="入力　説明" name="data[AdItem][is_view]" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">掲載開始日時</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="date" id="started_at" class="form-control" name="data[AdItem][started_at]" required value="{{ date("Y-m-d") }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-sm-right">掲載終了日時</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="date" id="ended_at" class="form-control" name="data[AdItem][ended_at]" required value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-8 text-right">
                                    <div class="btn-group">
                                        <button id="admin-submit" type="submit" class="btn btn-primary">作成</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        const getJobItem = (obj) => {
            const id = obj.selectedIndex;
            const value = obj.options[id].value;
            fetch(`/admin/ad_item/job_item/${value}`).then(resp => resp.json()).then(json => {
                console.log(json);
                const sel = document.getElementById("job_item");
                sel.textContent = null;
                const defaults = document.createElement("option");
                defaults.text = "掲載広告の選択";
                sel.appendChild(defaults);
                for(let i = 0; i < json.length; i++) {
                    const op = document.createElement("option");
                    op.value = json[i]["id"];
                    op.text = json[i]["job_title"];
                    sel.appendChild(op);
                }
                sel.disabled = false;
            });
        }

        $(function() {
            // let $parent = $('.parent');
            // let parentSalaryId = $('#parent_salary_id').val();
            // let $children = $('.children');
            // let isSalary = false;
            //
            // if ($parent.val() == parentSalaryId) isSalary = true;
            //
            // $('.parent').change(function() {
            //     let val1 = $(this).val();
            //     $children.find('option').each(function() {
            //         let val2 = $(this).data('val');
            //         isSalary = true;
            //         if (val1 != val2) {
            //             $(this).attr('selected', false)
            //             isSalary = false;
            //         }
            //     });
            //
            //     if (isSalary) {
            //         $children.show();
            //         $children.prop('required', true);
            //     } else {
            //         $children.hide();
            //         $children.prop('required', false);
            //     }
            //
            // });
            // if (isSalary) {
            //     $children.show();
            //     $children.prop('required', true);
            // } else {
            //     $children.hide();
            //     $children.prop('required', false);
            // }
        });
    </script>
@stop
