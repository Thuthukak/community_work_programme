@extends('layouts.crm')

@section('title', __('job.delete'))

@section('contents')
<h1 class="page-header" style="margin-top:40px">
    <div class="pull-right">
        {!! FormField::delete([
            'route' => ['jobs.destroy', $job]],
            __('app.delete_confirm_button'),
            ['class' => 'btn btn-sm btn-danger mr-5 mt-2 p-2'],
            [
                'project_job_id' => $job->id,
                'project_id' => $job->project_id,
            ]) !!}
    </div>
    {{ __('app.delete_confirm') }}
    {{link_to_route('jobs.show', __('app.cancel'), [$job], ['class' => 'btn btn-sm pull-right btn-warning']) }}
</h1>
<div class="row" style="margin:10px">
    <div class="col-md-4 showprojtable" style="margin-left:10px; padding-top:10px">
        @include('crm.jobs.partials.job-show')
    </div>
</div>
@endsection
