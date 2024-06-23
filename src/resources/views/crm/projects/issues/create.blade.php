@extends('crm.layouts.project')

@section('subtitle', __('issue.create'))

@section('action-buttons')
@can('create', new App\Models\ProjectManagement\Projects\Issue)
<div class="action-btns-container" style="display: flex;
    justify-content: flex-end;
    gap: 10px;">
    {!! html_link_to_route('projects.issues.create', __('issue.create'), $project, ['class' => 'btn btn-sm  mr-5 p-2 btn-primary', 'icon' => 'plus']) !!}
@endcan
@endsection

@section('content-project')

<div class="row showprojtable" style=" margin:10px;
    background: white;
    padding:2px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 5px;padding-top:10px">
    <div class="col-sm-6 col-sm-offset-2">
        {{ Form::open(['route' => ['projects.issues.store', $project]]) }}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('issue.create') }}</h3></div>
            <div class="panel-body">
                {!! FormField::text('title', ['label' => __('issue.title')]) !!}
                {!! FormField::textarea('body', ['label' => __('issue.body')]) !!}
                {!! FormField::radios('priority_id', $priorities, ['label' => __('issue.priority'), 'placeholder' => false]) !!}
                {!! FormField::select('pic_id', $users, ['label' => __('issue.pic')]) !!}
            </div>
            <div class="panel-footer">
                {{ Form::submit(__('issue.create'), ['class' => 'btn btn-success']) }}
                {{ link_to_route('projects.issues.index', __('app.cancel'), $project, ['class' => 'btn btn-default']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection
