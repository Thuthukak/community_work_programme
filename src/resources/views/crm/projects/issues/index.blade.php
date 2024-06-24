@inject('priorities', 'App\Models\ProjectManagement\Projects\Priority')
@inject('issueStatuses', 'App\Models\ProjectManagement\Projects\IssueStatus')
@extends('crm.layouts.project')

@section('subtitle', __('project.issues'))

@section('action-buttons')
<div class="action-buttons-wrapper" style="display: flex;
    justify-content: space-between;
    align-items: center; margin:20px;">
    {{ Form::open(['method' => 'get', 'class' => 'form-inline filter-form']) }}
    {!! FormField::select('priority_id', $priorities::toArray(), ['label' => false, 'placeholder' => __('issue.all_priority'), 'value' => request('priority_id'),'class' => 'form-control form-control-xs droplist', 'style'=>'margin-right: 10px;
    width: 200px !important; 
    font-size: 0.875rem !important;    
    padding: 0.5rem 0.5rem !important;']) !!}
    {!! FormField::select('status_id', $issueStatuses::toArray(), ['label' => false, 'placeholder' => __('issue.all_status'), 'value' => request('status_id'),'class' => 'form-control form-control-xs droplist','style'=>'margin-right: 10px;
    width: 200px !important; 
    font-size: 0.875rem !important;    
    padding: 0.5rem 0.5rem !important;']) !!}
    {{ Form::submit(__('app.filter'), ['class' => 'btn btn-info btn-sm mb-3 p-2']) }}
    @if (request(['priority_id', 'status_id']))
        {{ link_to_route('projects.issues.index', __('app.reset'), $project, ['class' => 'btn btn-default btn-sm p-2']) }}
    @endif
    {{ Form::close() }}

    <div class="create-button-wrapper" style=" margin-left: auto;">
        @can('create', new App\Models\ProjectManagement\Projects\Issue)
            {!! html_link_to_route('projects.issues.create', __('issue.create'), $project, ['class' => 'btn btn-warning btn-sm p-2', 'icon' => 'plus']) !!}
        @endcan
    </div>
</div>
@endsection



@section('content-project')
<div id="project-issues" class="issue-table panel panel-default table-responsive" style="background: white;
    padding:2px;
    padding-top:12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    padding-bottom: 50px;
    margin:20px;">
    <div class="panel-heading">
        <h3 class="panel-title">{{ __('project.issues') }}</h3>
    </div>
    <table class="table table-condensed ">
        <thead>
            <th>{{ __('app.table_no') }}</th>
            <th>{{ __('issue.title') }}</th>
            <th>{{ __('issue.priority') }}</th>
            <th>{{ __('app.status') }}</th>
            <th class="text-center">{{ __('comment.comment') }}</th>
            <th>{{ __('issue.pic') }}</th>
            <th>{{ __('issue.creator') }}</th>
            <th>{{ __('app.last_update') }}</th>
            <th class="text-center">{{ __('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($issues as $key => $issue)
            @php
            $no = 1 + $key;
            @endphp
            <tr id="{{ $issue->id }}">
                <td>{{ $no }}</td>
                <td>{{ $issue->title }}</td>
                <td>{!! $issue->priority_label !!}</td>
                <td class="text-black">{!! $issue->status_label !!}</td>
                <td class="text-center">{{ $issue->comments_count }}</td>
                <td>{{ $issue->pic->name }}</td>
                <td>{{ $issue->creator->name }}</td>
                <td>{{ $issue->updated_at->diffForHumans() }}</td>
                <td class="text-center">
                    {{ link_to_route(
                        'projects.issues.show',
                        __('app.show'),
                        [$project, $issue],
                        ['title' => __('issue.show')]
                    ) }}
                </td>
            </tr>
            @empty
            <tr><td colspan="9">{{ __('issue.not_found') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
