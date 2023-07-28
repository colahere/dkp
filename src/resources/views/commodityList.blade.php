@extends('web::layouts.grids.12')

@section('title', 'DKP')
@section('page_header', '成员DKP统计')

@push('head')
    <link rel="stylesheet"
          type="text/css"
          href="https://snoopy.crypta.tech/snoopy/seat-srp-approval.css"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/denngarr-srp-hook.css') }}"/>
@endpush

@section('full')
    <div class="card card-primary card-solid">
        <div class="card-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active nav-item"><a class="nav-link active" href="#tab_1"
                                                   data-toggle="tab">成员DKP统计</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table id="alldkps" class="table table-bordered">
                            <thead>
                            <tr>
				                <th>角色名</th>
                                <th>获取DKP</th>
				                <th>花费DKP</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach (json_decode($allDkpList,false) as $dkp)
                                <tr>
                                    <td>
                                        {{$dkp->name}}
                				    </td>
                                    <td>
                                        {{$dkp->all_score}}
                                        @if($dkp->all_score>0)
                                            <button data-toggle="modal" data-target="#dkp-detail"
                                                    data-url="{{ route('dkp.allScoreDetail', ['userId' => $dkp->user_id]) }}"
                                                    class="btn btn-sm btn-link">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        {{$dkp->use_score}}
                                        @if($dkp->use_score>0)
                                            <button data-toggle="modal" data-target="#dkp-detail"
                                                    data-url="{{ route('dkp.useScoreDetail', ['userId' => $dkp->user_id]) }}"
                                                    class="btn btn-sm btn-link">
                                                <i class="fas fa-eye"></i>
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
    @include('dkp::detail.show')
@stop

@push('javascript')

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script type="application/javascript">

        $(function () {
            $('#alldkps').DataTable();

        });
    </script>
@endpush
