
<div class="container-fluid mt-3">
  
    <div class="card mb-4">
        <div class="">
        </div>
        <div class="datatable mt-5 ml-4 mr-4">
            <div class="table-responsive">
            <table id="tablesocialLink" class="table table-sm table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr style="border-bottom: 1px solid var(--default-border-color);">
                        <th class="datatable-th">{{ __('theme.sl_no') }}</th>
                        <th class="datatable-th">{{ __('theme.name') }}</th>
                        <th class="datatable-th">{{ __('theme.icon') }}</th>
                        <th class="datatable-th">{{ __('theme.link') }}</th>
                        <th class="datatable-th">{{ __('theme.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                 
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <!-- add new modal -->
    <div class="modal fade" id="addNewSocial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title title-text" id="myModalLabel"> {{ __('theme.manage_social') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form method="POST" action="{{ route('socialAdd.Setting') }}" onsubmit="submitForm(event, this)">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group error">
                            <label for="name" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.name') }} :</strong> </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="name" name="name" placeholder="{{ __('theme.social_name') }}" required>
                            </div>
                        </div>
                        <div class="form-group error">
                            <label for="code" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.icon_code') }} :</strong> </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold demo" id="code" name="code" placeholder="Enter Fontawesome icon like fa fa-facebook" required>
                                <small class="text-danger"><strong>{{ __('theme.for_fontawesome_code_visit') }} : https://fontawesome.com/v4.7.0/icons/</strong> <br> {{ __('theme.enter_fontawesome_icon_like') }} fa fa-facebook</small>
                            </div>
                        </div>
                        <div class="form-group error">
                            <label for="link" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.link') }} :</strong> </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control has-error bold " id="link" name="link" placeholder="{{ __('theme.social_link') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-info" data-dismiss="modal"> {{ __('theme.close') }}</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary bold uppercase"> {{ __('theme.save') }}</button>
                                </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

