
<div class="container-fluid mt-3">
        <a href="javascript:void(0);" class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#addNew">
            <i class="fa fa-plus"></i> {{ __('theme.add_new') }}
        </a>
    </h4>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="page-title">{{ __('theme.social_link') }}</div>
        </div>
        <div class="card-body">
            <table id="table" class="table table-sm table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>{{ __('theme.sl_no') }}</th>
                        <th>{{ __('theme.name') }}</th>
                        <th>{{ __('theme.icon') }}</th>
                        <th>{{ __('theme.link') }}</th>
                        <th>{{ __('theme.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                 
                </tbody>
            </table>
        </div>
    </div>
    <!-- add new modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-share-square"></i> {{ __('theme.manage_social') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form method="POST" action="{{ route('socialAdd.Setting') }}">
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
                        <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('theme.close') }}</button>
                        <button type="submit" class="btn btn-primary bold uppercase"><i class="fas fa-arrow-alt-circle-up"></i> {{ __('theme.save_Social') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

