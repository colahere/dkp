<div class="modal fade" tabindex="-1" role="dialog" id="dkp-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-yellow">
                <h4 class="modal-title">
                    <i class="fas fa-trash-alt"></i>
                    修改
                </h4>
            </div>
            <div class="modal-body">
                <form id="formUpdate" method="POST" action="{{ route('dkp.settingDkpEdit') }}">
                    <input type="hidden" name="id">
                    <input type="hidden" name="setting_label" value="label">
                    {{-- dkp分数 --}}
                    <div id="score" class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">DKP分数:
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="score"
                                   placeholder="DKP分数">
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

