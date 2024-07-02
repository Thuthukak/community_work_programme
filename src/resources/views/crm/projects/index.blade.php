@extends('layouts.crm')

@section('title', trans('project.index_title', ['status' => $status]))

@section('contents')
<div id="app">
    <div class="project-header flex justify-between items-center mb-4">

        <h4 class="project-title page-header-pill text-xl custom-page-header font-semibold">
            {{ trans('project.index_title', ['status' => $status]) }}
        </h4>
        @can('create', new App\Models\ProjectManagement\Projects\Project)
        
            <div class="create-action-btns ml-auto">
                <div class="dropdown">
                    <button class="btn btn-success mr-2 btn-sm dropdown-toggle p-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ trans('project.action') }}
                        <i class="fas fa-caret-down arrow-icon" id="dropdownArrow"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @if ($projects->isNotEmpty() && $project = $projects->first())
                    <a class="dropdown-item {{ Request::segment(3) == 'jobs' ? 'active' : '' }}" href="{{ route('projects.jobs.index', $project->id) }}">
                        <i class="fas fa-tasks"></i> {!! __('project.jobs').' ('.$project->jobs->count().')' !!}
                    </a>

                    <a class="dropdown-item {{ Request::segment(3) == 'issues' ? 'active' : '' }}" href="{{ route('projects.issues.index', $project->id) }}">
                        <i class="fas fa-exclamation-circle"></i> {!! __('project.issues').' ('.$project->issues->count().')' !!}
                    </a>

                    <a class="dropdown-item {{ Request::segment(3) == 'comments' ? 'active' : '' }}" href="{{ route('projects.comments.index', $project->id) }}">
                        <i class="fas fa-comments"></i> {!! __('comment.list').' ('.$project->comments->count().')' !!}
                    </a>

                    <a class="dropdown-item {{ Request::segment(3) == 'files' ? 'active' : '' }}" href="{{ route('projects.files', $project->id) }}">
                        <i class="fas fa-file-alt"></i> {!! __('project.files').' ('.$project->files->count().')' !!}
                    </a>
                @else
                    <!-- Handle case where $projects is empty or null -->
                    <a class="dropdown-item disabled" href="#">
                        <i class="fas fa-exclamation-triangle"></i> No projects found
                    </a>
                @endif
                    </div>
                </div>
                <div class="create-project-btn ml-auto">
                <button class="btn btn-warning btn-sm p-2" data-toggle="modal" data-target="#createProjectModal">{{ trans('project.create') }}</button>

            </div>

        </div>
       
        @endcan
    </div>


   <!-- Modal -->
<div id="createProjectModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add Project') }}</h4>
            </div>
            {!! Form::open(['route' => 'projects.store', 'method' => 'POST']) !!}
            <div class="modal-body">
                {!! FormField::text('name', ['label' => trans('project.name')]) !!}
                {!! FormField::select('organization_id', $Organization, ['placeholder' => __('Organization')]) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('Organization Name') !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::text('Organization Email') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('proposal_date', ['label' => trans('project.proposal_date')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::price('proposal_value', ['label' => trans('project.proposal_value'), 'currency' => Option::get('money_sign', 'R')]) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => trans('project.description')]) !!}
            </div>
            <div class="modal-footer">
                {!! Form::submit(trans('Save'), ['class' => 'btn btn-success']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.cancel') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
 


 

    <div class="project-controls flex justify-between items-center mb-4">


        <div class="index-nav-tabs pull-left hidden-xs">@include('crm.projects.partials.index-nav-tabs')</div>
        {!! Form::open(['method' => 'get', 'class' => 'form-inline search-form']) !!}
        {{ Form::hidden('status_id') }}
        <div class="relative">
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i>
            </button>
            {!! Form::text('q', Request::get('q'), ['class' => 'form-control index-search-field', 'placeholder' => trans('project.search')]) !!}
        </div>
        {!! Form::close() !!}
    </div>
    <small class="custom-text-muted" style="margin-left:20px;">{{ $projects->total() }} {{ trans('project.found') }}</small>
<div class="table-wrapper shadow">
    <div class="panel panel-default table-responsive">        
        <table class="table  table-condensed  table-hover">
            <thead class="custom-th">
                <th>{{ trans('app.table_no') }}</th>
                <th>{{ trans('project.name') }}</th>
                <th class="text-center">{{ trans('project.start_date') }}</th>
                <th class="text-center">{{ trans('project.work_duration') }}</th>
                @if (request('status_id') == 2)
                <th class="text-right">{{ trans('project.overall_progress') }}</th>
                <th class="text-center">{{ trans('project.due_date') }}</th>
                @endif
                @can('see-pricings', new App\Models\ProjectManagement\Projects\Project)
                <th class="text-right">{{ trans('project.project_value') }}</th>
                @endcan
                <th class="text-center">{{ trans('app.status') }}</th>
                <th>{{ trans('project.customer') }}</th>
                <th>{{ trans('app.action') }}</th>
            </thead>
            <tbody>
                @forelse($projects as $key => $project)
                <tr>
                    <td>{{ $projects->firstItem() + $key }}</td>
                    <td>{{ $project->nameLink() }}</td>
                    <td class="text-center">{{ $project->start_date }}</td>
                    <td class="text-right">{{ $project->work_duration }}</td>
                    @if (request('status_id') == 2)
                    <td class="text-right">{{ format_decimal($project->getJobOveralProgress()) }} %</td>
                    <td class="text-center">{{ $project->due_date }}</td>
                    @endif
                    @can('see-pricings', new App\Models\ProjectManagement\Projects\Project)
                    <td class="text-right">{{ format_money($project->project_value) }}</td>
                    @endcan
                    <td class="text-center">{{ $project->present()->status }}</td>
                    <td>{{ $project->Organization?->name }}</td>
                    <td>
                        {!! html_link_to_route('projects.show', '', [$project->id], ['icon' => 'search', 'class' => 'btn btn-info btn-xs', 'title' => trans('app.show')]) !!}
                        <button class="btn btn-warning btn-xs edit-project-btn" data-id="{{ $project->id }}" data-toggle="modal" data-target="#editProjectModal" title="{{ trans('app.edit') }}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="9">{{ $status }} {{ trans('project.not_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<!-- Edit Modal -->
<div id="editProjectModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Edit Project') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => ['projects.update', 0], 'method' => 'patch', 'id' => 'editProjectForm']) !!}
                    <div class="panel-body">
                        {!! FormField::text('name', ['label' => __('project.name')]) !!}
                        <div class="row">
                            <div class="col-md-8">
                                {!! FormField::textarea('description', ['label' => __('project.description'), 'rows' => 5]) !!}
                            </div>
                            <div class="col-md-4">
                                {!! FormField::price('proposal_value', ['label' => __('project.proposal_value'), 'currency' => Option::get('money_sign', 'R')]) !!}
                                {!! FormField::price('project_value', ['label' => __('project.project_value'), 'currency' => Option::get('money_sign', 'R')]) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {!! FormField::text('proposal_date', ['label' => __('project.proposal_date')]) !!}
                            </div>
                            <div class="col-md-6">
                                {!! FormField::text('start_date', ['label' => __('project.start_date')]) !!}
                            </div>

                        </div>
                        <div class ="row">
                            <div class="col-md-6">
                                {!! FormField::text('due_date', ['label' => __('project.due_date')]) !!}
                            </div>
                            <div class="col-md-6">
                                {!! FormField::text('end_date', ['label' => __('project.end_date')]) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>{{ __('Organization') }}</label><br>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.cancel') }}</button>
                {!! Form::submit(trans('Save'), ['class' => 'btn btn-success']) !!}
            </div>
        </div>
    </div>
</div>


    {{ $projects->appends(Request::except('page'))->render() }}
</div>
@endsection
@section('script')
<!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> -->
<script>
$(document).ready(function($) {

    var $j = jQuery.noConflict();

  // Initialize datetimepicker
  $j('#proposal_date, #start_date, #due_date, #end_date').datetimepicker({
    timepicker: false,
    format: 'Y-m-d',
    closeOnDateSelect: true,
    scrollInput: false
  });

  // Handle click event for .edit-project-btn
  $j('.edit-project-btn').on('click', function() {
    var projectId = $(this).data('id');
    var url = "{{ route('projects.edit', ':id') }}"; // Adjust route as per your application

    // AJAX request to fetch project details
    $j.ajax({
      url: url.replace(':id', projectId),
      method: 'GET',
      success: function(data) {
        // Populate form fields with fetched project data
        $j('#editProjectForm').attr('action', "{{ route('projects.update', 0) }}".replace('/0', '/' + data.id));
        $j('#editProjectForm input[name="name"]').val(data.name);
        $j('#editProjectForm textarea[name="description"]').val(data.description);
        $j('#editProjectForm input[name="proposal_date"]').val(data.proposal_date);
        $j('#editProjectForm input[name="start_date"]').val(data.start_date);
        $j('#editProjectForm input[name="due_date"]').val(data.due_date);
        $j('#editProjectForm input[name="end_date"]').val(data.end_date);
        $j('#editProjectForm select[name="status_id"]').val(data.status_id);
        $j('#editProjectModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error('Error fetching project data:', error);
      }
    });
  });
});
</script>