@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')

@section('title', 'Knowledge Base')

@section('main-section')
    
    <!-- Main content -->
    <div class="container-fluid">
        @if($permission->manageKB() == 1)
        <h4 class="page-title">{{ __('theme.knowledge_base') }}
            <a href="{{ route('knowledge-base-create.create') }}" class="btn btn-primary btn-md pull-right">{{ __('theme.add_new') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('includes.flash')
                        @include('kb.table', ['departments' => $departments])
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        @else
            <div class="callout callout-warning">
                <h4>{{ __('theme.access_denied') }}</h4>

                <p>{{ __("theme.don't_have_permission") }}</p>
            </div>
        @endif
        <!-- /.row -->
    </div>
    <!-- /.content -->

@endsection