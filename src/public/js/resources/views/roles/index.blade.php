@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')

@section('title', __('theme.manage_role'))

@section('style')
    
@stop
@section('title', 'Roles')

@section('main-section')
    <!-- Main content -->
    <div class="container-fluid">
        @if($permission->manageRole() == 1)
        <h4 class="page-title">{{ __('theme.roles') }}
            <a href="{{ route('role-create.create') }}" class="btn btn-primary pull-right">{{ __('theme.add_new') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('includes.flash')
                    <!-- /.box-header -->
                    <div class="card-body table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                            <tr>
                                <th>{{ __('theme.sl_no') }}</th>
                                <th>{{ __('theme.title') }}</th>
                                <th>{{ __('theme.title') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                               
                            @if ($roles->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">
                                    <p>{{ __('theme.currently_no_roles_found') }}</p>
                                </td>
                            </tr> 
                            @else
                                @foreach($roles as $role)
                            <tr>
                                <td>{{ $loop->index +1 }}</td>
                                <td>{{ $role->title }}</td>
                                <td>
                                    <a href="{{ route('role-edit.editPermission', $role->id) }}" class="badge badge-primary"><i class="fa fa-pencil"></i></a>
                                    
                                    <form id="delete-form-{{ $role->id }}" method="post" action="{{ route('role-delete.delete', $role->id) }}" style="display: none">
                                        {{csrf_field()}}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    <a href="" class="badge bg-danger text-white" onclick="
                                            if(confirm('Are you sure, You want to Delete this ??'))
                                            {
                                            event.preventDefault();
                                            document.getElementById('delete-form-{{ $role->id }}').submit();
                                            }
                                            else {
                                            event.preventDefault();
                                            }"><i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{ $roles->links() }}
                    </div>
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