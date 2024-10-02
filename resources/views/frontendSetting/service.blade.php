
<div class="container-fluid">
        
    </h4>
    @include('tickets.flash')
    <div class="row">
        <div class="col-md-4">
            <div class="mb-4">
                <div class="card-body">
                    <form action="{{ route('setting.servicesUpdate') }}" method="post" onsubmit="submitForm(event, this)">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="service_title"><strong>{{ __('theme.service_title') }}</strong></label>
                                <input class="form-control form-control-lg mb-3 {{ $errors->has('service_title') ? ' is-invalid' : '' }}" name="service_title" value=""  type="text" required>
                                <input class="form-control form-control-lg mb-3" name="id" value=""  type="hidden">
                                @if ($errors->has('service_title'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('service_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="service_details"><strong>{{ __('theme.service_details') }}</strong></label>
                                <textarea class="form-control" id="service_details" rows="2" name="service_details" required></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('theme.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="page-title">{{ __('theme.services') }}</div>
                </div>
                <div class="card-body table-responsive">
                    <table id="testimonialTableServices" class="table table-sm table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('theme.sl_no') }}</th>
                                <th>{{ __('theme.name') }}</th>
                                <th>{{ __('theme.icon') }}</th>
                                <th>{{ __('theme.details') }}</th>
                                <th>{{ __('theme.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <div class="modal fade" id="addNewService" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title title-text" id="myModalLabel">{{ __('theme.add_New_service') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <form method="POST" action="{{ route('service.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.title') }} :</strong> </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control has-error bold " id="title" name="title" value="{{ old('title') }}" required="">
                                </div>
                            </div>
                            <div class="form-group error">
                                <label for="icon" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.icon_code') }} :</strong> </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control has-error bold demo" id="icon" name="icon" placeholder="Enter Fontawesome icon like fa fa-facebook" required>
                                    <small class="text-danger"><strong>{{ __('theme.for_fontawesome_code_visit') }} : https://fontawesome.com/v4.7.0/icons/</strong> <br> {{ __('theme.enter_fontawesome_icon_like') }} fa fa-facebook</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="details" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.details') }} :</strong> </label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="details" rows="2" name="details" required>{{  old('details') }}</textarea>
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



