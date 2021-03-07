@extends('adminlte::page')

@section('title', 'JOB CiNEMA | 成果報酬管理')

@section('content_header')
    <h1><i class="fas fa-home mr-2"></i>成果報酬管理</h1>
@stop

@section('content_bread')
    <li class="breadcrumb-item active">成果報酬管理</li>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="tableAchieveReward" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>応募</th>
                            <th>支払い</th>
                            <th>支払日</th>
                            <th>返金依頼</th>
                            <th>返金依頼日</th>
                            <th>返金処理</th>
                            <th>登録日</th>
                            <th>更新日</th>
                            <th class="nosort">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$achieve_rewards->isEmpty())
                            @foreach($achieve_rewards as $achieve_reward)
                                <tr>
                                    <td>{{ $achieve_reward->id }}</td>
                                    <td><a href="/admin/data/application/{{ $achieve_reward->apply_id }}">{{ $achieve_reward->apply_id }}</a></td>
                                    <td> @if($achieve_reward->is_payed) 支払い済み @else 未払い @endif </td>
                                    <td>{{ ($achieve_reward->payed_at == null)?"未払い" :$achieve_reward->payed_at->toDateString() }}</td>
                                    <td> @if($achieve_reward->is_return_requested) 受付 @else 無し @endif </td>
                                    <td>{{ ($achieve_reward->return_requested_at == null)?"無し" :$achieve_reward->return_requested_at->toDateString() }}</td>
                                    <td> @if($achieve_reward->is_returned) 済み @else 無し @endif </td>
                                    <td>{{ $achieve_reward->created_at->toDateString() }}</td>
                                    <td>{{ $achieve_reward->updated_at->toDateString() }}</td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm" href="{{ route('achieve_reward.show', $achieve_reward->id) }}">
                                            <i class="fas fa-eye">
                                            </i>
                                        </a>
                                        <a class="btn btn-info btn-sm" href="{{ route('achieve_reward.edit', $achieve_reward->id) }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <p>データがありません</p>
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(function() {
            $('#tableAchieveReward').DataTable({
                "paging": true,
                "searching": true,
                "scrollX": true,
                "ordering": true,
                "lengthMenu": [10, 20, 30, 40, 50, 100],
                "displayLength": 50,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [{
                    "targets": 'nosort',
                    "orderable": false
                }]
            });

        });
    </script>
@stop
