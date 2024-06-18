@extends('crm.layouts.project')

@section('action-buttons')
<div class="d-flex justify-content-end">
    @can('update', $project)
        {!! link_to_route('projects.edit', __('project.edit'), $project, ['class' => 'btn btn-warning btn-sm mr-2']) !!}
    @endcan
    {!! link_to_route('projects.index', __('project.back_to_index'), ['status_id' => $project->status_id], ['class' => 'btn btn-info btn-sm']) !!}
</div>
@endsection
@section('content-project')
<div class="row">
    <div class="col-md-6">
        @include('crm.projects.partials.project-show')
    </div>
    <div class=" update-status col-md-6">
        @can('update', $project)
        {!! Form::model($project, ['route' => ['projects.status-update', $project], 'method' => 'patch', 'class' => 'well well-sm form-inline']) !!}
        {!! FormField::select('status_id', ProjectStatus::toArray(), ['label' => __('project.status'), 'class' => 'mr-2']) !!}
        {!! Form::submit(__('project.update_status'), ['class' => 'btn btn-info btn-m', 'style' => 'position: relative; top: -6px;']) !!}
        {!! Form::close() !!}
        @endcan
        @include('crm.projects.partials.project-stats')
    </div>
    <div>
</div>
</div>
@endsection
