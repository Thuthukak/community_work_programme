@extends('crm.layouts.project')

<!-- Include Flatpickr CSS from cdnjs -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.css">

@section('action-buttons')
<div class="d-flex justify-content-end">
    @can('update', $project)

        <div class="edit-project-btn ml-auto">
            <button class="btn btn-warning btn-sm p-2" data-toggle="modal" data-target="#EditProjectModal">{{ trans('Edit Project') }}</button>
        </div>
    @endcan
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


      <!-- Edit modal -->

      <div id="EditProjectModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Update Project') }}</h4>
            </div>
            {!! Form::model($project, ['route' => ['projects.update', $project], 'method' => 'patch']) !!}
            <div class="modal-body">
                <div class="panel-body">
                    {!! FormField::text('name', ['label' => __('project.name')]) !!}
                    <div class="row">
                        <div class="col-md-8">
                            {!! FormField::textarea('description', ['label' => __('project.description'), 'rows' => 5]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! FormField::price('proposal_value', ['label' => __('project.proposal_value'), 'currency' => Option::get('money_sign', 'R')]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {!! FormField::text('proposal_date', ['label' => __('project.proposal_date'), 'id' => 'proposal_date']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! FormField::text('start_date', ['label' => __('project.start_date'), 'id' => 'start_date']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! FormField::text('due_date', ['label' => __('project.due_date'), 'id' => 'due_date']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! FormField::text('end_date', ['label' => __('project.end_date'), 'id' => 'end_date']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! FormField::select('status_id', ProjectStatus::toArray(), ['label' => __('app.status')]) !!}
                        </div>

                        <div class="col-md-6">
                            <label>{{ __('Organization') }}</label><br>
                            <a href="{{ route('organizations.show', ['organization' => $project->organization_id]) }}">
                                {{ __($Organization->name) }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::submit(trans('Save'), ['class' => 'btn btn-success']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.cancel') }}</button>
                @can('delete', $project)
                {!! link_to_route('projects.delete', __('app.delete'), [$project], ['class' =>'btn btn-danger pull-right']) !!}
                @endcan
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection

<!-- Include Flatpickr JS from cdnjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.js"></script>

<!-- Your script to initialize Flatpickr -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr on the date input fields
        flatpickr("#proposal_date, #start_date, #due_date, #end_date", {
            dateFormat: "Y-m-d",
            disableMobile: true // optional: to force the desktop version on mobile devices
        });
    });
</script>
