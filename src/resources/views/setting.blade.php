@extends('web::layouts.grids.12')

@section('title', 'DKP')
@section('page_header', '参数设置')

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
    @include('dkp::setting.create_setting')


    <div class="card card-primary card-solid">
        <div class="card-body">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <table id="dkpsetting" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>类别</th>
                                <th>船只名/技能名</th>
                                <th>数量/技能等级</th>
                                <th>停放空间站</th>
                                <th>DKP分数</th>
                                <th>生效时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach (json_decode($dkpConfig,false) as $dkp)
                                <tr>
                                    <td>
                                        {{$dkp->label}}
                                    </td>
                                    <td>
                                        {{$dkp->name}}
                                    </td>
                                    <td>
                                        {{$dkp->num}}
                                    </td>
                                    <td>
                                        {{$dkp->station}}
                                    </td>
                                    <td>
                                        {{$dkp->score}}
                                    </td>
                                    <td>
                                        {{$dkp->update_at}}
                                    </td>

                                    <td>
                                        <button type="button" data-toggle="modal" data-op-id="{{ $dkp->id }}"
                                                data-target="#dkp-edit"
                                                class="btn btn-xs btn-link">
                                            <i class="fas fa-pencil-alt snoopy" data-toggle="tooltip"
                                               data-placement="top" title="修改"></i>
                                        </button>

                                        <button type="button" data-toggle="modal" data-op-id="{{ $dkp->id }}"
                                                data-target="#dkp-delete"
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
    @include('dkp::setting.delete_setting')
    @include('dkp::setting.update_setting')
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
            $('#dkp-delete').on('show.bs.modal', function (e) {
                var id = $(e.relatedTarget).data('op-id');

                $(e.currentTarget).find('input[name="id"]').val(id);
            });
            $('#dkp-edit').on('show.bs.modal', function (e) {
                var id = $(e.relatedTarget).data('op-id');

                $(e.currentTarget).find('input[name="id"]').val(id);
            });
        });


    </script>
@endpush
