@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')

@section('title', __('theme.custom_fields'))

@section('main-section')
    <!-- Main content -->
    <div class="container-fluid">
        @if($permission->manageDepartment() == 1)
        <h4 class="page-title">{{ __('theme.custom_fields') }}
            <a href="#" class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#addNewDept">
                <i class="fa fa-plus"></i>  {{ __('theme.add_new') }}
            </a>
        </h4>
        @include('includes.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- /.box-header -->
                    @include('customFields.table')
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
            <!-- modal -->
            <div class="modal fade" id="addNewDept" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-share-square"></i> {{ __('theme.add_custom_field') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form method="POST" action="{{ route('CustomFieldStore') }}">
                            @csrf
                            <div class="modal-body form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.name') }}</strong> </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="title" name="name" placeholder="Enter name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.type') }}</strong> </label>
                                        <div class="col-sm-12">
                                            <select class="form-control" name="type">
                                                <option value="text">text</option>
                                                <option value="select">select</option>
                                                <option value="radio">radio</option>
                                                <option value="checkbox">checkbox</option>
                                                <option value="file">file</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="placeholder" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.placeholder') }}</strong> </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold" id="placeholder" name="placeholder" placeholder="Enter placeholder">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_length" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.field_length') }}</strong> </label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control has-error bold" min="1" id="field_length" name="field_length" placeholder="Enter field length">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('theme.required') }}</label><br>
                                        <div class="form-check-inline">
                                            <label class="customradio"><span class="radiotextsty">{{ __('theme.yes') }}</span>
                                            <input type="radio" name="required" value="1">
                                            <span class="checkmark"></span>
                                            </label>        
                                            <label class="customradio"><span class="radiotextsty">{{ __('theme.no') }}</span>
                                            <input type="radio" name="required" value="0">
                                            <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('theme.status') }}</label><br>
                                        <div class="form-check-inline">
                                            <label class="customradio"><span class="radiotextsty">{{ __('theme.active') }}</span>
                                            <input type="radio" checked="checked" name="status" value="1">
                                            <span class="checkmark"></span>
                                            </label>        
                                            <label class="customradio"><span class="radiotextsty">{{ __('theme.inactive') }}</span>
                                            <input type="radio" name="status" value="0">
                                            <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('theme.close') }}</button>
                                <button type="submit" class="btn btn-primary bold uppercase"><i class="fas fa-arrow-alt-circle-up"></i> {{ __('theme.save') }}</button>
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
    <!-- /.content -->
@endsection