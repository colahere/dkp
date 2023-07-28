<div class="modal fade in" tabindex="-1" role="dialog" id="dkp-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">DKP详情</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

@push('javascript')
    <script>
        $('#dkp-detail').on('show.bs.modal', function (e) {
            var body = $(e.target).find('.modal-body');
            body.html('Loading...');

            $.ajax($(e.relatedTarget).data('url'))
                .done(function (data) {
                    body.html(data);
                    $('body').find('#allDkp').dataTable({
                        lengthMenu: [5, 10, 15],
                        ordering: false,
                        pageLength: 5
                    });
                });
        });
    </script>
@endpush