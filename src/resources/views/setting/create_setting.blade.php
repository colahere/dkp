<div class="modal fade" tabindex="-1" role="dialog" id="createSetting">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-green">
                <h4 class="modal-title">
                    <i class="fas fa-space-shuttle"></i>
                    新增DKP项
                </h4>
            </div>
            <div class="modal-body">
                <div class="modal-errors alert alert-danger d-none">
                    <ul></ul>
                </div>
                <form class="form-horizontal" action="{{ route('dkp.settingDkpAdd') }}" method="post" id="formCreateSetting">
                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">DKP类别:
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="setting_label" id="setting_label"
                                    onchange="selectLabel()">
                                <option value="" selected></option>
                                <option value="login">登录</option>
                                <option value="skill">技能</option>
                                <option value="asset">战备</option>
                                <option value="bounty">赏金(单位：百万ISK)</option>
                                <option value="mining">挖矿(单位：千立方)</option>
                                <option value="pap">pap</option>
                            </select>
                        </div>
                    </div>

                    {{-- 技能名 --}}
                    <div id="skill_name" class="form-group row" style="display: none;">
                        <label for="title" class="col-sm-3 col-form-label">技能名:
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="skill_name"
                                   placeholder="技能名">
                        </div>
                    </div>

                    {{-- 技能等级 --}}
                    <div id="skill_level" class="form-group row" style="display: none;">
                        <label for="title" class="col-sm-3 col-form-label">技能等级:
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="skill_level"
                                   placeholder="技能等级">
                        </div>
                    </div>


                    {{-- 船只名 --}}
                    <div id="ship_name" class="form-group row" style="display: none;">
                        <label for="title" class="col-sm-3 col-form-label">船只名:
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="ship_name"
                                   placeholder="船只名">
                        </div>
                    </div>

                    {{-- 空间站名 --}}
                    <div id="station_name" class="form-group row" style="display: none;">
                        <label for="title" class="col-sm-3 col-form-label">停放空间站:
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="station_name"
                                   placeholder="停放空间站">
                        </div>
                    </div>

                    {{-- 船只数量 --}}
                    <div id="ship_num" class="form-group row" style="display: none;">
                        <label for="title" class="col-sm-3 col-form-label">船只数量:
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="ship_num"
                                   placeholder="船只数量">
                        </div>
                    </div>

                    {{-- dkp分数 --}}
                    <div id="score" class="form-group row" style="display: none;">
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
                    <button type="button" class="btn btn-success" id="create_setting_submit">
                        <i class="fas fa-check-circle"></i> 确定
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('javascript')
    <script type="text/javascript">

        function selectLabel() {
            var val = $('#setting_label option:selected').val();
            if ("login" == val) {
                $('#skill_name').hide();
                $('#skill_level').hide();
                $('#ship_name').hide();
                $('#station_name').hide();
                $('#ship_num').hide();
                $('#score').show();
            }
            if ("skill" == val) {
                $('#skill_name').show();
                $('#skill_level').show();
                $('#ship_name').hide();
                $('#station_name').hide();
                $('#ship_num').hide();
                $('#score').show();
            }
            if ("asset" == val) {
                $('#skill_name').hide();
                $('#skill_level').hide();
                $('#ship_name').show();
                $('#station_name').show();
                $('#ship_num').show();
                $('#score').show();

            }
            if ("bounty" == val) {
                $('#skill_name').hide();
                $('#skill_level').hide();
                $('#ship_name').hide();
                $('#station_name').hide();
                $('#ship_num').hide();
                $('#score').show();
            }
            if ("mining" == val) {
                $('#skill_name').hide();
                $('#skill_level').hide();
                $('#ship_name').hide();
                $('#station_name').hide();
                $('#ship_num').hide();
                $('#score').show();
            }
            if ("pap" == val) {
                $('#skill_name').hide();
                $('#skill_level').hide();
                $('#ship_name').hide();
                $('#station_name').hide();
                $('#ship_num').hide();
                $('#score').show();
            }
        }

        $('#create_setting_submit').click(function () {
            $('#formCreateSetting').submit();
        });

    </script>
@endpush
