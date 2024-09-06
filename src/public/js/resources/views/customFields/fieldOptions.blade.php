@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')

@section('title', __('theme.custom_field_options'))

@section('main-section')
    <!-- Main content -->
    <div class="container-fluid">
        @if($permission->manageDepartment() == 1)
        <h4 class="page-title">{{ __('theme.custom_field_options') }}
            <a href="#" class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#addNewDept">
                <i class="fa fa-plus"></i>  {{ __('theme.add_new') }}
            </a>
            <a href="{{ route('CustomFields') }}" class="btn btn-secondary float-right mr-2">Back to Custom Field</a>
        </h4>
        @include('includes.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- /.box-header -->
                    @include('customFields.optionTable',['field_id' => $field->id])
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
                        <form method="POST" action="{{ route('CustomFieldOptionStore', $field->id) }}">
                            @csrf
                            <div class="modal-body form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="value" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.value') }}</strong> </label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control has-error bold " id="value" name="value" placeholder="Enter value" required>
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