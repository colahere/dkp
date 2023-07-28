<div class="modal fade" tabindex="-1" role="dialog" id="commodity-rollback">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title">
                    <i class="fas fa-trash-alt"></i>
                    撤回
                </h4>
            </div>
            <div class="modal-body">
                <p>你真的确定要撤回？</p>
                <form id="formDelete" method="POST" action="{{ route('dkp.rollbackCommodity') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id">
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

