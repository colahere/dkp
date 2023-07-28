<div class="modal fade" tabindex="-1" role="dialog" id="supplement-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-yellow">
                <h4 class="modal-title">
                    <i class="fas fa-trash-alt"></i>
                    修改
                </h4>
            </div>
            <div class="modal-body">
                <form id="formUpdate" method="POST" action="{{ route('dkp.supplementUpdate') }}">
                    <input type="hidden" name="id">
                    <input type="hidden" name="supplement_name" value="supplement_name">
                    {{-- 兑换条件(总DKP需求) --}}
                    <div id="all_dkp" class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">兑换条件(总DKP要求):
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="all_dkp"
                                   placeholder="兑换条件(总DKP要求)">
                        </div>
                    </div>

                    {{-- 需求DKP --}}
                    <div id="use_dkp" class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">花费DKP:
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="use_dkp"
                                   placeholder="花费DKP">
                        </div>
                    </div>

                    {{-- 库存 --}}
                    <div id="supplement_num" class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">库存:
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="supplement_num"
                                   placeholder="库存">
                        </div>
                    </div>
                    {{ csrf_field() }}
                </form>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i> 取消
                    </button>
                    <button type="button" class="btn btn-warning" id="confirm_submit">
                        <i class="fas fa-check-circle"></i> 确定
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('javascript')

    <script>
        $('#confirm_submit').click(function () {
            $('#formUpdate').submit();
        });
    </script>
@endpush

