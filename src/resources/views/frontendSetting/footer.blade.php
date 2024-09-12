
<div class="container-fluid">
    <h4 class="page-title">{{ __('theme.footer_setting') }}</h4>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('updateFooter.Setting') }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="footer_text"><strong>{{ __('theme.footer_text') }}</strong></label>
                            <input id="footer_text" class="form-control mb-3" name="footer_text" value=""  type="text" required>
                            <input type="hidden" value="{" name="id">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 font-weight-bold text-uppercase">{{ __('theme.contact_us') }}</div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group pt-0 mb-0 pb-0">
                            <label for="contact_title"><strong>{{ __('theme.contact_title') }}</strong></label>
                            <input id="contact_title" class="form-control mb-3" name="contact_title" value=""  type="text" required>
                            <input type="hidden" value="" name="id">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group pt-0 mb-0 pb-0">
                            <label for="address"><strong>{{ __('theme.contact_address') }}</strong></label>
                            <input id="address" class="form-control mb-3" name="contact_address" value=""  type="text" required>
                            <input type="hidden" value="" name="id">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group pt-0 mb-0 pb-0">
                            <label for="contact_phone"><strong>{{ __('theme.contact_phone') }}</strong></label>
                            <input id="contact_phone" class="form-control mb-3" name="contact_phone" value=""  type="text" required>
                            <input type="hidden" value="" name="id">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group pt-0 mb-0 pb-0">
                            <label for="contact_email"><strong>{{ __('theme.contact_email') }}</strong></label>
                            <input id="contact_email" class="form-control mb-3" name="contact_email" value=""  type="text" required>
                            <input type="hidden" value="" name="id">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('theme.update') }}</button>
                </div>
            </form>
        </div>
    </div>

</div>

