<div class="modal fade" tabindex="-1" role="dialog" id="createSetting">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <h4 class="modal-title">
                    <i class="fas fa-space-shuttle"></i>
                    新增商品
                </h4>
            </div>
            <div class="modal-body">
                <div class="modal-errors alert alert-danger d-none">
                    <ul></ul>
                </div>
                <form class="form-horizontal" action="{{ route('dkp.createSupplement') }}" method="post"
                      id="formCreateSupplement">

                    {{-- 物品名称 --}}
                    <div id="supplement_name" class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">物品名称:
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="supplement_name"
                                   placeholder="物品名称">
                        </div>
                    </div>
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
                    <button type="button" class="btn btn-success" id="create_supplement_submit">
                        <i class="fas fa-check-circle"></i> 确定
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('javascript')
    <script type="text/javascript">

        $('#create_supplement_submit').click(function () {
            $('#formCreateSupplement').submit();
        });

    </script>
@endpush
