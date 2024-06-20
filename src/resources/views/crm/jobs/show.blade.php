@extends('crm.layouts.job')

@section('subtitle', __('job.detail'))

@section('action-buttons')
@can('create', new App\Models\ProjectManagement\Projects\ProjectJob)
    {!! html_link_to_route('projects.jobs.create', __('job.create'), [$job->project_id], ['class' => 'btn btn-success', 'icon' => 'plus']) !!}
@endcan
@can('update', $job)
    {{ link_to_route('jobs.edit', __('job.edit'), [$job], ['class' => 'btn btn-warning']) }}
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
<div class="row">
    <div class=" main-areabg col-md-8 col-md-offset-2">
    </div>
</div>
@endsection

@section('ext_css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/rangeslider.css') }}">
    <style>
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
        $('#ap_weight').text(ap_weight);
    });

    $('#commentModal').modal({
        show: true,
        backdrop: 'static',
    });
})();
</script>
@endsection
