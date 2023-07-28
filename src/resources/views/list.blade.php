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
        <div class="card-body">
            <div class="progress" style="width: 30%;">
                @if(($sumDkp == 0))
                    <div class="progress-bar bg-success" role="progressbar"
                         style="width: 100%"
                         aria-valuenow="{{$sumDkp-$lockDkp-$isUseDkp}}"
                         aria-valuemin="0"
                         aria-valuemax="100">可兑换:{{$sumDkp-$lockDkp-$isUseDkp}}
                    </div>
                @else
                    <div class="progress-bar bg-success" role="progressbar"
                         style="width: {{($sumDkp-$lockDkp-$isUseDkp)/$sumDkp*100}}%"
                         aria-valuenow="{{$sumDkp-$lockDkp-$isUseDkp}}"
                         aria-valuemin="0"
                         aria-valuemax="100">可兑换:{{$sumDkp-$lockDkp-$isUseDkp}}
                    </div>
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{$lockDkp/$sumDkp*100}}%"
                         aria-valuenow="{{$lockDkp}}"
                         aria-valuemin="0"
                         aria-valuemax="100">锁定:{{$lockDkp}}
                    </div>
                    <div class="progress-bar progress-bar-striped bg-info" role="progressbar"
                         style="width: {{$isUseDkp/$sumDkp*100}}%" aria-valuenow="{{$isUseDkp}}" aria-valuemin="0"
                         aria-valuemax="100">已兑换:{{$isUseDkp}}
                    </div>
                @endif
            </div>
            累计获取:{{$sumDkp}}
        </div>
    </div>
    <br>
    <div class="card card-primary card-solid">
        <div class="card-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">我的DKP</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">我的兑换</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table id="dkps" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>角色名</th>
                                <th>DKP</th>
                                <th>获取时间</th>
                                <th>获取原由</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dkpList as $dkp)
                                @if(($dkp->status == 1))
                                    <tr>
                                        <td>
                                            {{$dkp->name}}
                                        </td>
                                        <td>
                                            {{$dkp->score}}
                                        </td>
                                        <td>{{$dkp->created_at}}</td>
                                        <td>
                                            {{$dkp->remark}}
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <table id="dkps-arch" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>角色名</th>
                                <th>花费DKP</th>
                                <th>兑换时间</th>
                                <th>兑换物品</th>
                                <th>兑换状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dkpList as $dkp)
                                @if(($dkp->status == 2)||($dkp->status == 3)||($dkp->status == 0))
                                    <tr>
                                        <td>
                                            {{$dkp->name}}
                                        </td>
                                        <td>
                                            {{$dkp->score}}
                                        </td>
                                        <td>{{$dkp->created_at}}</td>
                                        <td>
                                            {{$dkp->remark}}
                                        </td>
                                        <td>
                                            @if ($dkp->approved === 0)
                                                <span class="badge badge-warning">待审批</span>
                                            @elseif ($dkp->approved === -1)
                                                <span class="badge badge-danger">已拒绝</span>
                                            @elseif ($dkp->approved === 1)
                                                <span class="badge badge-success">已批准</span>
                                            @elseif ($dkp->approved === 2)
                                                <span class="badge badge-primary">已交付</span>
                                            @endif
                                        </td>

                                    </tr>
                                @endif
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
            $('#dkps').DataTable();

            $('#dkps-arch').DataTable();
        });
    </script>
@endpush