@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')

@section('title', __('theme.themedepartments'))

@section('title', 'All Department')

@section('main-section')
    <!-- Main content -->
    <div class="container-fluid">
        @if($permission->manageDepartment() == 1)
        <h4 class="page-title">{{ __('theme.departments') }}
            <a href="#" class="btn btn-primary btn-md float-right" data-toggle="modal" data-target="#addNewDept">
                <i class="fa fa-plus"></i>  {{ __('theme.add_new') }}
            </a>
        </h4>
        @include('includes.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- /.box-header -->
                    @include('departments.table')
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
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-share-square"></i> {{ __('theme.add_new_department') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form method="POST" action="{{ route('department-save.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.title') }} :</strong> </label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control has-error bold " id="title" name="title" placeholder="Enter department title" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-3 control-label bold uppercase"><strong>{{ __('theme.description') }} :</strong> </label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" id="description" rows="2" name="description" required>{{  old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('theme.close') }}</button>
                                <button type="submit" class="btn btn-primary bold uppercase"><i class="fas fa-arrow-alt-circle-up"></i> {{ __('theme.save_department') }}</button>
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