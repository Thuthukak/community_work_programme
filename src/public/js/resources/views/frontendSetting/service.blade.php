@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', __('theme.service_setting'))

@section('main-section')
<div class="container-fluid">
    @if($permission->manageService() == 1)
    <h4 class="mb-4">{{ __('theme.service_setting') }}
        <a href="#" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#addNew">
            <i class="fa fa-plus"></i>  {{ __('theme.add_new') }}
        </a>
    </h4>
    @include('includes.flash')
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('setting.servicesUpdate') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="service_title"><strong>{{ __('theme.service_title') }}</strong></label>
                                <input class="form-control form-control-lg mb-3 {{ $errors->has('service_title') ? ' is-invalid' : '' }}" name="service_title" value="{{ $setting->service_title ?? old('service_title') }}"  type="text" required>
                                <input class="form-control form-control-lg mb-3" name="id" value="{{ $setting->id }}"  type="hidden">
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
                                <textarea class="form-control" id="service_details" rows="2" name="service_details" required>{{ $setting->service_details ?? old('service_details') }}</textarea>
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
                    <table id="testimonialTable" class="table table-sm table-hover" cellspacing="0" width="100%">
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
                            @foreach($services as $key=>$service)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $service->title }}</td>
                                <td><i class="{{ $service->icon }}"></i></td>
                                <td>
                                    {!! str_limit(clean($service->details), 15,'') !!}
                                    @if(str_word_count(clean($service->details)) > 5)
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#commentDetails{{ $service->id }}" title="View Details">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <div class="modal fade" id="commentDetails{{ $service->id }}" role="dialog" aria-labelledby="#commentDetails" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">&nbsp; {{ __('theme.service_details') }} </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>{!! clean($service->details) !!}</strong></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('theme.close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#editService{{ $service->id }}" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <div class="modal fade" id="editService{{ $service->id }}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="editServiceModalLabel"><i class="fa fa-share-square"></i> {{ __("theme.edit_service") }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <form method="POST" action="{{ route('service.update',$service->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <div class="col-md-12 mb-2">
                                                                    <label for="title" class="float-left ml-0">
                                                                    <strong>{{ __('theme.title') }} :</strong>
                                                                </label>
                                                                    <input type="text" class="form-control has-error bold " id="name" name="title" value="{{ $service->title ?? old('title') }}" placeholder="{{ __('theme.service_title') }}">
                                                                </div>

                                                                <label for="icon" class="ml-3">
                                                                    <strong>{{ __('theme.icon_code') }} :</strong>
                                                                </label>
                                                                <div class="col-md-12 mb-2">
                                                                    <input type="text" class="form-control has-error bold demo" id="icon" value="{{ $service->icon ?? old('icon') }}" name="icon" placeholder="Enter Fontawesome icon like fa fa-facebook">
                                                                    <small class="text-danger"><strong>{{ __('theme.for_fontawesome_code_visit') }} : https://fontawesome.com/v4.7.0/icons/</strong><br>
                                                                        {{ __('theme.enter_fontawesome_icon_like') }} fa fa-facebook
                                                                    </small>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <label for="details" class="float-left ml-0"><strong>{{ __('theme.details') }} :</strong>
                                                                </label>
                                                                    <textarea class="form-control" id="details" rows="2" name="details">{{ $service->details ?? old('details') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('theme.close') }}</button>
                                                        <button type="submit" class="btn btn-primary bold uppercase"><i class="fas fa-arrow-alt-circle-up"></i> {{ __('theme.update_service') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm delete_button" data-toggle="modal" data-target="#delete{{ $service->id }}" title="DELETE">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="modal fade" id="delete{{ $service->id }}" role="dialog" aria-labelledby="#delete" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form method="POST" action="{{ route('service.destroy',$service->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="delete"><i class="fa fa-trash"></i>&nbsp;{{ __('theme.delete') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>{{ __('theme.are_you_sure_you_want_to_delete') }}</strong></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('theme.no') }}</button>
                                                        <button type="submit" class="btn btn-danger">{{ __('theme.delete') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>                 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-share-square"></i> {{ __('theme.add_New_service') }}</h4>
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
                            <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('theme.close') }}</button>
                            <button type="submit" class="btn btn-primary bold uppercase"><i class="fas fa-arrow-alt-circle-up"></i> {{ __('theme.save_service') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="callout callout-warning">
            <h4>{{ __('theme.access_denied') }}</h4>

            <p>{{ __("theme.don't_have_permission") }}</p>
        </div>
    @endif
</div>



@endsection