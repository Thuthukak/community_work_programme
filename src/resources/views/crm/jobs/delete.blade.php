@extends('layouts.crm')

@section('title', __('job.delete'))

@section('contents')
<h1 class="page-header" style="margin-top:40px; font-family: Poppins, sans-serif !important;
    color:#374151 !important;
    line-height:27px  !important  ;
    font-weight:400 !important; color:red; font-size:22px; margin-left:30px;">
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
    {{link_to_route('jobs.show', __('app.cancel'), [$job], ['class' => 'btn btn-sm pull-right btn-info']) }}
</h1>
<div class="row" style="margin:10px">
    <div class="col-md-4 showprojtable" style="margin-left:10px; padding-top:10px;margin:10px;
    background: white;
    padding:2px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 5px; padding:10px;">
        @include('crm.jobs.partials.job-show')
    </div>
</div>
@endsection
