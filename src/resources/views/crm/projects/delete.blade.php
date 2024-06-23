@extends('layouts.crm')

@section('title', trans('project.delete'))

@section('contents')
<h1 class="page-header"  style="margin-top:40px; font-family: Poppins, sans-serif !important;
    color:#374151 !important;
    line-height:27px  !important  ;
    font-weight:400 !important; color:red; font-size:22px; margin-left:30px;" >
    <div class="pull-right">
        {!! FormField::delete(['route'=>['projects.destroy',$project->id]], trans('app.delete_confirm_button'), ['class'=>'btn btn-danger btn-sm mr-5 mt-2 p-2'], ['project_id'=>$project->id]) !!}
    </div>
    {{ trans('app.delete_confirm') }}
    {!! link_to_route('projects.show', trans('app.cancel'), [$project->id], ['class' => 'btn btn-sm pull-right btn-info']) !!}
</h1>
<div class="row" style="margin:10px">
    <div class="col-md-6 col-md-offset-2" style="margin-left:10px; padding-top:10px;margin:10px;
    background: white;
    padding:2px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 5px; padding:10px;">
        @include('crm.projects.partials.project-show')
    </div>
</div>
@endsection
