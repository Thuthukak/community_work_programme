@extends('layouts.crm')

@section('title', __('job.edit'))

@section('contents')
<div class="row" style="margin:20px"><br>
    <div class="col-md-5">
        {!! Form::model($job, ['route' => ['jobs.update', $job], 'method' => 'patch']) !!}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ $job->name }} <small>{{ __('job.edit') }}</small></h3></div>
            <div class="panel-body" style="margin-top:20px">
                {!! FormField::text('name', ['label' => __('job.name')]) !!}
                {!! FormField::textarea('description', ['label' => __('job.description')]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        {!! FormField::price('price', ['label' => __('job.price'), 'currency' => Option::get('money_sign', 'R')]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::select('person_id', $persons, ['label' => __('Assign to')]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::radios('type_id', [1 => __('job.main'), __('job.additional')], ['value' => 1, 'label' => __('job.type'), 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">{!! FormField::text('target_start_date', ['label' => __('job.target_start_date'), 'class' => 'date-select']) !!}</div>
                    <div class="col-md-4">{!! FormField::text('target_end_date', ['label' => __('job.target_end_date'), 'class' => 'date-select']) !!}</div>
                </div>
                <div class="row">
                    <div class="col-md-4">{!! FormField::text('actual_start_date', ['label' => __('job.actual_start_date'), 'class' => 'date-select']) !!}</div>
                    <div class="col-md-4">{!! FormField::text('actual_end_date', ['label' => __('job.actual_end_date'), 'class' => 'date-select']) !!}</div>
                </div>
            </div>

            <div class="panel-footer">
                {!! Form::hidden('project_id', $job->project_id) !!}
                {!! Form::submit(__('job.update'), ['class' => 'btn btn-primary']) !!}
                {{ link_to_route('jobs.show', __('app.show'), [$job], ['class' => 'btn btn-success']) }}
                {{ link_to_route('projects.jobs.index', __('job.back_to_index'), [$job->project_id], ['class' => 'btn btn-info']) }}
                {{ link_to_route('jobs.delete', __('job.delete'), [$job], ['class' => 'btn btn-danger pull-right']) }}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        @include('crm.projects.partials.project-show', ['project' => $job->project])
    </div>
</div>
@endsection

<!-- @section('ext_css')
    <link rel="stylesheet" href="{{ url('assets/css/plugins/jquery.datetimepicker.css') }}">
@endsection


@section('ext_js')
    <script src="{{ url('assets/js/plugins/jquery.datetimepicker.js') }}"></script>
@endsection


@section('script')
<script>
(function() {
    $('.date-select').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endsection -->
