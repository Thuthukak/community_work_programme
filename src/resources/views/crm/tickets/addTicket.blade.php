<div class="modal fade" id="addTicketModal" tabindex="-1" role="dialog" aria-labelledby="addTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 1000px !important;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTicketModalLabel">{{ __('theme.add_new_ticket') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Include the form here, ensure the form has id="customerform" -->
                    @include('crm.tickets.create')
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('theme.close') }}</button>
                    </div>
                    <div class="col-md-6">
                    <button type="submit" form="customerform" class="btn btn-primary">{{ __('theme.submit') }}</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>