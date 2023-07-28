@extends('web::layouts.grids.12')

@section('title', 'DKP')
@section('page_header', '我的DKP')

@push('head')
    <link rel="stylesheet"
          type="text/css"
          href="https://snoopy.crypta.tech/snoopy/seat-srp-approval.css"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/denngarr-srp-hook.css') }}"/>
@endpush

@section('full')
    <div class="card card-primary card-solid">
        <div class="card-header">
            <h3 class="card-title">申请列表</h3>
        </div>
        <div class="card-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">待处理</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">已完结</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table id="approve" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>兑换角色名</th>
                                <th>兑换物品</th>
                                <th>花费DKP</th>
                                <th>兑换时间</th>
                                <th>当前状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dkpList as $dkp)

                                <tr>
                                    <td>
                                        {{$dkp->name}}
                                    </td>
                                    <td>
                                        {{$dkp->remark}}
                                    </td>
                                    <td>{{$dkp->score}}</td>
                                    <td>
                                        {{$dkp->created_at}}
                                    </td>

                                    @if ($dkp->approved === 0)
                                        <td id="id-{{ $dkp->id }}"><span class="badge badge-warning">待审批</span></td>
                                    @elseif ($dkp->approved === -1)
                                        <td id="id-{{ $dkp->id }}"><span class="badge badge-danger">已拒绝</span></td>
                                    @elseif ($dkp->approved === 1)
                                        <td id="id-{{ $dkp->id }}"><span class="badge badge-success">已批准</span></td>
                                    @elseif ($dkp->approved === 2)
                                        <td id="id-{{ $dkp->id }}"><span class="badge badge-primary">已支付</span></td>
                                    @endif

                                    <td>
                                        <button type="button" class="btn btn-xs btn-danger approve-status"
                                                id="approve-status"
                                                name="{{ $dkp->id }}" value="Reject">拒绝
                                        </button>
                                        <button type="button" class="btn btn-xs btn-success approve-status"
                                                id="approve-status"
                                                name="{{ $dkp->id }}" value="Approve">批准
                                        </button>
                                        <button type="button" class="btn btn-xs btn-primary approve-status"
                                                id="approve-status"
                                                name="{{ $dkp->id }}" value="Paid Out">支付
                                        </button>
                                    </td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <table id="approve-arch" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>兑换角色名</th>
                                <th>兑换物品</th>
                                <th>花费DKP</th>
                                <th>兑换时间</th>
                                <th>状态</th>
                                <th>审批人</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dkpList2 as $dkp2)

                                <tr>
                                    <td>
                                        {{$dkp2->name}}
                                    </td>
                                    <td>
                                        {{$dkp2->remark}}
                                    </td>
                                    <td>{{$dkp2->score}}</td>
                                    <td>
                                        {{$dkp2->created_at}}
                                    </td>
                                    @if ($dkp2->approved === 0)
                                        <td><span class="badge badge-warning">待审批</span></td>
                                    @elseif ($dkp2->approved === -1)
                                        <td><span class="badge badge-danger">已拒绝</span></td>
                                    @elseif ($dkp2->approved === 1)
                                        <td><span class="badge badge-success">已批准</span></td>
                                    @elseif ($dkp2->approved === 2)
                                        <td><span class="badge badge-primary">已支付</span></td>
                                    @endif
                                    <td>
                                        {{$dkp2->approver}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@push('javascript')

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script type="application/javascript">

        $(function () {
            $('#approve').DataTable();

            $('#approve-arch').DataTable();

            $('#approve tbody').on('click', 'button', function (btn) {
                $.ajax({
                    headers: function () {
                    },
                    url: "{{ route('dkp.approve') }}/" + btn.target.name + "/" + btn.target.value,
                    dataType: 'json',
                    timeout: 5000
                }).done(function (data) {
                    if (data.name === "Approve") {
                        $("#id-" + data.value).html('<span class="badge badge-success">已批准</span>');
                    } else if (data.name === "Reject") {
                        $("#id-" + data.value).html('<span class="badge badge-danger">已拒绝</span>');
                    } else if (data.name === "Paid Out") {
                        $("#id-" + data.value).html('<span class="badge badge-primary">已支付</span>');
                    } else if (data.name === "Pending") {
                        $("#id-" + data.value).html('<span class="badge badge-warning">待审批</span>');
                    }
                    // $("#approver-"+data.value).html(data.approver);
                    location.reload(bForceGet = true);
                });

            });

        });
    </script>
@endpush
