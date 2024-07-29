@extends('crm.layouts.project')

@section('subtitle', __('job.create'))

@section('action-buttons')
@can('create', new App\Models\ProjectManagement\Projects\ProjectJob)
<div class="action-btns-container">
<button class="btn btn-warning btn-sm p-2" data-toggle="modal" data-target="#createTaskModal" data-project-id="{{ $project->id }}">{{ trans('Add New Task') }}</button>
    {!! html_link_to_route('projects.jobs.add-from-other-project', __('job.add_from_other_project'), [$project->id], ['class' => 'btn btn-sm btn-success p-2', 'icon' => 'plus']) !!}
@endcan
@endsection

@section('content-project')

<div class="row showprojtable">
    <div class="col-sm-6 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title" style="margin:20px">{{ __('job.add_from_other_project') }}</h3></div>
            <div class="panel-body">
                {{ Form::open(['method' => 'get', 'class' => 'form-inline', 'style' => 'margin-bottom:20px']) }}
                {!! FormField::select('project_id', $projects, [
                    'label' => false,
                    'value' => request('project_id'),
                    'placeholder' => __('project.select'),
                ]) !!}
                {{ Form::submit(__('project.show_jobs'), ['class' => 'btn btn-info btn-sm mb-4']) }}
                {{ Form::close() }}
                @if ($selectedProject)
                {{ Form::open(['route' => ['projects.jobs.store-from-other-project', $project->id]]) }}
                <ul class="list-unstyled">
                    @forelse($selectedProject->jobs as $key => $job)
                    <li>
                        <label for="project_project_job_id_{{ $job->id }}"  style="margin:20px">
                        {{ Form::checkbox('project_project_job_ids['.$job->id.']', $job->id, null, ['id' => 'project_project_job_id_'.$job->id]) }}
                        {{ $job->name }}</label>
                        <ul style="list-style-type:none">
                            @foreach($job->tasks as $task)
                            <li>
                                <label for="{{ $job->id }}_task_id_{{ $task->id }}" style="font-weight:normal">
                                {{ Form::checkbox($job->id.'_task_ids['.$task->id.']', $task->id, null, ['id' => $job->id.'_task_id_'.$task->id, 'class' => 'project_project_job_id_'.$job->id.'_tasks']) }}
                                {{ $task->name }}</label>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @empty
                    <li><div class="alert alert-info">{{ __('job.not_found') }}</div></li>
                    @endforelse
                </ul>
                @else
                    <div class="alert alert-info">{{ __('job.select_project') }}</div>
                @endif
                @if ($errors->has('project_project_job_ids'))
                    <div class="alert alert-danger">{{ __('validation.select_one') }}</div>
                @endif
                
                {{ Form::submit(__('job.add'), ['class' => 'btn btn-success btn-sm ml-4'],) }}
                {{ Form::close() }}
            </div>

            <div class="panel-footer"  style="margin:20px">
                {{ link_to_route('projects.jobs.index', __('app.cancel'), [$project], ['class' => 'btn btn-sm btn-danger']) }}
            </div>
        </div>
    </div>
</div>


<!-- Create task modal -->
<div id="createTaskModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add Task') }}</h4>
            </div>
            {!! Form::open(['route' => ['projects.jobs.store', $project->id], 'method' => 'POST']) !!}
            <div class="modal-body">
                {!! FormField::text('name', ['label' => trans('job.name')]) !!}

                {!! FormField::textarea('description', ['label' => __('job.description')]) !!}

            
                <div class="row">
                    <div class="col-sm-4">
                        {!! FormField::price('price', [
                            'label'    => __('job.price'),
                            'currency' => Option::get('money_sign', 'Rp'),
                            'value'    => 0,
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::select('person_id', $persons, ['label' => __('Assign to'), 'value' => 1]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::radios('type_id', [1 => __('job.main'), __('job.additional')], ['value' => 1, 'label' => __('job.type'), 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('target_start_date', ['label' => __('job.target_start_date'), 'class' => 'date-select']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::text('target_end_date', ['label' => __('job.target_end_date'), 'class' => 'date-select']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{ Form::submit(__('Save'), ['class' => 'btn btn-primary']) }}
                {{ link_to_route('projects.jobs.index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('ext_css')
<script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>

    <style>
    .select2-selection.select2-selection--single {
        border-radius: 0;
        height: 30px;
    }
    </style>
@endsection
@section('script')
<script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for select[name=project_id]
    $('select[name=project_id]').select2();

    // Initialize Flatpickr for date inputs
    flatpickr(".date-select", {
        dateFormat: "Y-m-d",
        disableMobile: true // optional: to force the desktop version on mobile devices
    });

    @if ($selectedProject)
        @foreach ($selectedProject->jobs as $job)
            $('#project_job_id_{{ $job->id }}').change(function () {
                $('.project_job_id_{{ $job->id }}_tasks').prop('checked', this.checked);
            });

            @foreach($job->tasks as $task)
                $('#{{ $job->id }}_task_id_{{ $task->id }}').change(function () {
                    var condition = false;

                    $.each($(".project_job_id_{{ $job->id }}_tasks"), function( key, value ) {
                        if(value.checked == true){
                            condition = true;
                        }
                    });

                    if(condition) {
                        $('#project_job_id_{{ $job->id }}').prop('checked', true);
                    }
                });
            @endforeach
        @endforeach
    @endif
});
</script>

@endsection
