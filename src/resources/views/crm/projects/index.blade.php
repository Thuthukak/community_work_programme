@extends('layouts.crm')

@section('title', trans('project.index_title', ['status' => $status]))

@section('contents')

<!-- <projects></projects> -->
<div class="project-header flex justify-between items-center mb-4">
    <h1 class="project-title text-xl font-semibold">
        {{ trans('project.index_title', ['status' => $status]) }} 
        <small>{{ $projects->total() }} {{ trans('project.found') }}     
        </small>
    </h1>
    @can('create', new App\Models\ProjectManagement\Projects\Project)
    <div class="create-project-btn ml-auto">
        {!! link_to_route('projects.create', trans('project.create'), [], ['class' => 'btn btn-warning btn-sm p-2']) !!}
    </div>
    @endcan
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
@endsection
