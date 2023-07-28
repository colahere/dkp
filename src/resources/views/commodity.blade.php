@extends('web::layouts.grids.12')

@section('title', 'DKP')
@section('page_header', 'DKP兑换')

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
                    <li class="active nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">商品信息</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">兑换记录</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table id="dkps" class="table">
                            @foreach($DkpSupplement as $key=>$dkpSupp)
                                @if($key==0)
                                    <tr>
                                        @endif
                                        <th>
                                            <div class="card" style="width: 18rem; background-color: #d7f4fe;">

                                                <div class="card-body">
                                                    <h5 class="card-title"
                                                        style="font-size: 25px;">{{$dkpSupp->supplement_name}}</h5>
                                                    <p class="card-text">总DKP:
                                                        @if($sumDkp<$dkpSupp->all_dkp)
                                                            <span style="color: red">{{$dkpSupp->all_dkp}}</span>
                                                        @else
                                                            {{$dkpSupp->all_dkp}}
                                                        @endif

                                                        <br>
                                                        花费DKP:
                                                        @if(($sumDkp-$lockDkp-$isUseDkp)<$dkpSupp->use_dkp)
                                                            <span style="color: red">{{$dkpSupp->use_dkp}}</span>
                                                        @else
                                                            {{$dkpSupp->use_dkp}}
                                                        @endif
                                                        <br>
                                                        库存:
                                                        @if($dkpSupp->supplement_num<1)
                                                            <span style="color: red">{{$dkpSupp->supplement_num}}</span>
                                                        @else
                                                            {{$dkpSupp->supplement_num}}
                                                        @endif

                                                    </p>
                                                    @if(($sumDkp-$lockDkp-$isUseDkp)<$dkpSupp->use_dkp || $sumDkp<$dkpSupp->all_dkp ||$dkpSupp->supplement_num<1)
                                                        <a href="#" class="btn btn-default disabled">不可兑换</a>
                                                    @else
                                                        <a href='{{ route('dkp.exchangeCommodity', ['supplementId' => $dkpSupp->id,'userId'=> auth()->user()->id])}}'
                                                           class="btn btn-primary">兑换</a>
                                                    @endif

                                                </div>
                                            </div>
                                        </th>
                                        @if(($key+1)%5==0)
                                    </tr>
                                    <tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <table id="dkps-arch" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>兑换角色名</th>
                                <th>兑换物品</th>
                                <th>花费DKP</th>
                                <th>兑换时间</th>
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
                                    <td>
                                        @if ($dkp->approved === 0)
                                            <button type="button" class="btn btn-xs btn-danger srp-status"
                                                    data-op-id="{{ $dkp->id }}" data-toggle="modal"
                                                    data-target="#commodity-rollback"
                                                    value="Reject">撤回
                                            </button>
                                        @endif
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
    @include('dkp::commodity.rollback')
@stop

@push('javascript')

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script type="application/javascript">

        $(function () {
            $('#dkps-arch').DataTable();


            $('#commodity-rollback').on('show.bs.modal', function (e) {
                var id = $(e.relatedTarget).data('op-id');

                $(e.currentTarget).find('input[name="id"]').val(id);
            });
        });
    </script>
@endpush