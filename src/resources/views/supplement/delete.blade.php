<div class="modal fade" tabindex="-1" role="dialog" id="supplement-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title">
                    <i class="fas fa-trash-alt"></i>
                    删除
                </h4>
            </div>
            <div class="modal-body">
                <p>你真的确定要删除？</p>
                <form id="formDelete" method="POST" action="{{ route('dkp.supplementDelete') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id">
                    <input type="hidden" name="supplement_name" value="supplement_name">
                    <input type="hidden" name="supplement_num" value="1">
                    <input type="hidden" name="use_dkp" value="1">
                    <input type="hidden" name="all_dkp" value="1">
                    <input type="hidden" name="remark" value="1">
                </form>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i> 取消
                    </button>
                    <button type="button" class="btn btn-danger" id="confirm_delete_submit">
                        <i class="fas fa-check-circle"></i> 确定
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('javascript')

    <script>
        $('#confirm_delete_submit').click(function () {
            $('#formDelete').submit();
        });
    </script>
@endpush

