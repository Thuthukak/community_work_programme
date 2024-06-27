@extends('crm.layouts.job')

@section('subtitle', __('job.detail'))

@section('action-buttons')
@can('create', new App\Models\ProjectManagement\Projects\ProjectJob)
    {!! html_link_to_route('projects.jobs.create', __('job.create'), [$job->project_id], ['class' => 'btn btn-success', 'icon' => 'plus']) !!}
@endcan
@can('update', $job)
<button class="btn btn-warning btn-sm p-1" data-toggle="modal" data-target="#EditTaskModal">{{ trans('Edit Task') }}</button>
@endcan
@endsection

@section('content-job')

<div class="main-area-main row">
    <div class="main-areabg col-md-5">
        @include('crm.jobs.partials.job-show')
        @include('crm.jobs.partials.job-dates')
    </div>
    <div class="main-areabg col-sm-6">
        @include('crm.jobs.partials.job-tasks-operation')
        @include('crm.jobs.partials.job-tasks')
    </div>
</div>
<!-- <div class="row">
    <div class=" main-areabg col-md-8 col-md-offset-2">
    </div>
</div> -->

<!-- Edit task modal -->
<div id="EditTaskModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl"> <!-- Increased modal width -->
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Edit Task') }}</h4>
            </div>
            {!! Form::open(['route' => ['jobs.update', $job], 'method' => 'patch']) !!}
            <div class="modal-body">
                <div class="row">
                    <!-- Edit Form Column -->
                    <div class="col-md-6">
                        {!! FormField::text('name', ['label' => trans('job.name'), 'value' => $job->name]) !!}
                        {!! FormField::textarea('description', ['label' => __('job.description'), 'value' => $job->description]) !!}
                        <div class="row">
                            <div class="col-sm-4">
                                {!! FormField::price('price', [
                                    'label'    => __('job.price'),
                                    'currency' => Option::get('money_sign', 'R'),
                                    'value'    => $job->price,
                                ]) !!}
                            </div>
                            <div class="col-md-4">
                                {!! FormField::select('person_id', $persons, ['label' => __('Assign to'), 'value' => $job->person_id]) !!}
                            </div>
                            <div class="col-sm-4">
                                {!! FormField::radios('type_id', [1 => __('job.main'), __('job.additional')], ['value' => $job->type_id, 'label' => __('job.type'), 'list_style' => 'unstyled']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! FormField::text('target_start_date', ['label' => __('job.target_start_date'), 'class' => 'date-select', 'value' => $job->target_start_date]) !!}
                            </div>
                            <div class="col-md-6">
                                {!! FormField::text('target_end_date', ['label' => __('job.target_end_date'), 'class' => 'date-select', 'value' => $job->target_end_date]) !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            {!! Form::hidden('project_id', $job->project_id) !!}
                            {!! Form::submit(__('job.update'), ['class' => 'btn  btn-primary']) !!}
                            {{ link_to_route('jobs.show', __('app.show'), [$job], ['class' => 'btn btn-xs btn-success']) }}
                            {{ link_to_route('projects.jobs.index', __('job.back_to_index'), [$job->project_id], ['class' => 'btn btn-xs btn-info']) }}
                            {{ link_to_route('jobs.delete', __('job.delete'), [$job], ['class' => 'btn btn-xs btn-danger pull-right']) }}
                        </div>
                    </div>
                    <!-- Project Details Column -->
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">{{ __('Project Details') }}</h3>
                            </div>
                            <div class="panel-body">
                                @include('crm.projects.partials.project-show', ['project' => $job->project])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('ext_css')
<link rel="stylesheet" href="{{ asset('assets/css/plugins/rangeslider.css') }}">    <style>
        .rangeslider--horizontal {
            margin-top: 10px;
            margin-bottom: 10px;
            height: 10px;
        }
        .rangeslider--horizontal .rangeslider__handle {
            top : -5px;
            width: 20px;
            height: 20px;
        }
        .rangeslider--horizontal .rangeslider__handle:after {
            width: 8px;
            height: 8px;
        }
        ul.pagination { margin-top: 0px }
    </style>
@endsection

@section('ext_js')
<script src="{{ asset('assets/js/plugins/rangeslider.min.js') }}"></script>
@endsection

@section('script')
<script>
(function() {
    $('input[type="range"]').rangeslider({ polyfill: false });

    $(document).on('input', 'input[type="range"]', function(e) {
        var ap_weight = e.currentTarget.value;
        console.log("Range value:", ap_weight);
        $('#ap_weight').text(ap_weight);
    });

    $('#commentModal').modal({
        show: true,
        backdrop: 'static',
    });
})();
</script>
@endsection
