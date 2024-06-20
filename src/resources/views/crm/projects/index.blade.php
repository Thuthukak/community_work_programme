@extends('layouts.crm')

@section('title', trans('project.index_title', ['status' => $status]))

@section('contents')
<div id="app">



    <div class="project-header flex justify-between items-center mb-4">
        <h1 class="project-title text-xl font-semibold">
            {{ trans('project.index_title', ['status' => $status]) }}
            <small>{{ $projects->total() }} {{ trans('project.found') }}</small>
        </h1>
        @can('create', new App\Models\ProjectManagement\Projects\Project)
        <div class="container mt-5">
            <div class="create-action-btn ml-auto">
                <div class="dropdown">
                    <button class="btn btn-warning btn-sm dropdown-toggle p-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            </div>
        </div>
       <div class="create-project-btn ml-auto">
    <button class="btn btn-warning btn-sm p-2" data-toggle="modal" data-target="#createProjectModal">{{ trans('project.create') }}</button>
</div>

        @endcan
    </div>


   <!-- Modal -->
<div id="createProjectModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ __('project.create') }}</h4>
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
                        {!! FormField::price('proposal_value', ['label' => trans('project.proposal_value'), 'currency' => Option::get('money_sign', 'Rp')]) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => trans('project.description')]) !!}
            </div>
            <div class="modal-footer">
                {!! Form::submit(trans('project.create'), ['class' => 'btn btn-success']) !!}
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

    <div class="project-table panel panel-default table-responsive">
        <table class="table table-condensed table-hover">
            <thead>
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
                    <td>{{ $project->customer->name }}</td>
                    <td>
                        {!! html_link_to_route('projects.show', '', [$project->id], ['icon' => 'search', 'class' => 'btn btn-info btn-xs', 'title' => trans('app.show')]) !!}
                        {!! html_link_to_route('projects.edit', '', [$project->id], ['icon' => 'edit', 'class' => 'btn btn-warning btn-xs', 'title' => trans('app.edit')]) !!}
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
    {{ $projects->appends(Request::except('page'))->render() }}
</div>
@endsection

<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            console.log('Form submitted'); // Check if this message appears in the browser console
        });
    });
</script>
