@extends('web::layouts.grids.12')

@section('title', 'DKP')
@section('page_header', '兑换设置')

@push('head')
    <link rel="stylesheet"
          type="text/css"
          href="https://snoopy.crypta.tech/snoopy/seat-srp-approval.css"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/denngarr-srp-hook.css') }}"/>
@endpush

@section('full')
    <div class="row margin-bottom">
        <div class="col-md-offset-8 col-md-4">
            <div class="pull-right">
                <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#createSetting">
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;
                    新增
                </button>
            </div>
        </div>
    </div>
    @include('dkp::supplement.create')


    <div class="card card-primary card-solid">
        <div class="card-body">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <table id="dkpsetting" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>物品名称</th>
                                <th>兑换条件(总DKP要求)</th>
                                <th>花费DKP</th>
                                <th>库存</th>
                                <th>上架时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($DkpSupplement as $dkp)
                                <tr>
                                    <td>
                                        {{$dkp->supplement_name}}
                                    </td>
                                    <td>
                                        {{$dkp->all_dkp}}
                                    </td>
                                    <td>
                                        {{$dkp->use_dkp}}
                                    </td>
                                    <td>
                                        {{$dkp->supplement_num}}
                                    </td>
                                    <td>
                                        {{$dkp->updated_at}}
                                    </td>
                                    <td>
                                        <button type="button" data-toggle="modal" data-op-id="{{ $dkp->id }}"
                                                data-all-dkp="{{ $dkp->all_dkp }}" data-use-dkp="{{ $dkp->use_dkp }}"
                                                data-supplement-num="{{ $dkp->supplement_num }}"
                                                data-target="#supplement-edit"
                                                class="btn btn-xs btn-link">
                                            <i class="fas fa-pencil-alt snoopy" data-toggle="tooltip"
                                               data-placement="top" title="修改"></i>
                                        </button>

                                        <button type="button" data-toggle="modal" data-op-id="{{ $dkp->id }}"
                                                data-target="#supplement-delete"
                                                class="btn btn-sm btn-link">
                                            <i class="fas fa-trash-alt text-danger" data-toggle="tooltip"
                                               data-placement="top"
                                               title="删除"></i>
                                        </button>

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
    @include('dkp::supplement.delete')
    @include('dkp::supplement.update')
@stop

@push('javascript')

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>

    <script type="application/javascript">

        $(function () {
            $('#dkpsetting').DataTable();

            $('#supplement-delete').on('show.bs.modal', function (e) {
                var id = $(e.relatedTarget).data('op-id');

                $(e.currentTarget).find('input[name="id"]').val(id);
            });

            $('#supplement-edit').on('show.bs.modal', function (e) {
                var id = $(e.relatedTarget).data('op-id');
                var all_dkp = $(e.relatedTarget).data('all-dkp');
                var use_dkp = $(e.relatedTarget).data('use-dkp');
                var supplement_num = $(e.relatedTarget).data('supplement-num');

                $(e.currentTarget).find('input[name="id"]').val(id);
                $(e.currentTarget).find('input[name="all_dkp"]').val(all_dkp);
                $(e.currentTarget).find('input[name="use_dkp"]').val(use_dkp);
                $(e.currentTarget).find('input[name="supplement_num"]').val(supplement_num);
            });
        });


    </script>
@endpush
