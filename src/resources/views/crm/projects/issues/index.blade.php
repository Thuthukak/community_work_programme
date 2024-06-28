@inject('priorities', 'App\Models\ProjectManagement\Projects\Priority')
@inject('issueStatuses', 'App\Models\ProjectManagement\Projects\IssueStatus')
@extends('crm.layouts.project')

@section('subtitle', __('project.issues'))

@section('action-buttons')
<div class="action-buttons-wrapper">
    {{ Form::open(['method' => 'get', 'class' => 'form-inline filter-form']) }}
    {!! FormField::select('priority_id', $priorities::toArray(), ['label' => false, 'placeholder' => __('issue.all_priority'), 'value' => request('priority_id'),'class' => 'form-control form-control-xs droplist']) !!}
    {!! FormField::select('status_id', $issueStatuses::toArray(), ['label' => false, 'placeholder' => __('issue.all_status'), 'value' => request('status_id'),'class' => 'form-control form-control-xs droplist']) !!}
    {{ Form::submit(__('app.filter'), ['class' => 'btn btn-info btn-sm mb-3 p-2']) }}
    @if (request(['priority_id', 'status_id']))
        {{ link_to_route('projects.issues.index', __('app.reset'), $project, ['class' => 'btn btn-default btn-sm p-2']) }}
    @endif
    {{ Form::close() }}

    <div class="create-button-wrapper">
        @can('create', new App\Models\ProjectManagement\Projects\Issue)
            <button class="btn btn-warning btn-sm p-2 mb-3" data-toggle="modal" data-target="#createIssueModal" data-project-id="{{ $project->id }}">{{ trans('Add Issue') }}</button>

        @endcan
    </div>
</div>
@endsection



@section('content-project')
<div class="panel-heading">
        <h3 class="panel-title custom-text-muted table-margin">{{ __('project.issues') }}</h3>
    </div>
<div class="table-wrapper shadow">
<div id="project-issues" class="panel panel-default table-responsive">  
    <table class="table table-condensed">
        <thead class="custom-th2">
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
                <td class="text-black" style="text-color: black">{!! $issue->status_label !!}</td>
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
</div>


<div id="createIssueModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add Issue') }}</h4>
            </div>
                    {!! Form::open(['route' => ['projects.issues.store', $project->id], 'method' => 'POST']) !!}
            <div class="modal-body">
                    {!! FormField::text('title', ['label' => __('issue.title')]) !!}
                    {!! FormField::textarea('body', ['label' => __('issue.body')]) !!}
                <div class="row">
                {!! FormField::radios('priority_id', $priorities::toArray(), ['label' => false, 'placeholder' => __('issue.all_priority'), 'value' => request('priority_id'),'class' => 'form-control form-control-xs droplist']) !!}
                </div>
                <div class="row">
                    {!! FormField::select('pic_id', $users, ['label' => __('issue.pic')]) !!}

                </div>
            </div>
            <div class="modal-footer">
                    {{ Form::submit(__('Save'), ['class' => 'btn btn-primary']) }}
                    {{ link_to_route('projects.issues.index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
