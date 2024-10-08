@inject('priorities', 'App\Models\ProjectManagement\Projects\Priority')
@inject('issueStatuses', 'App\Models\ProjectManagement\Projects\IssueStatus')
@extends('layouts.crm')

@section('subtitle', __('issue.issues'))

@section('action-buttons')
<div class="action-buttons-cont">
    {{ Form::open(['method' => 'get', 'class' => 'form-inline', 'style' => 'display:inline']) }}
    {!! FormField::select('priority_id', $priorities::toArray(), ['label' => false, 'placeholder' => __('issue.all_priority'), 'value' => request('priority_id'), 'icon' => 'plus']) !!}
    {!! FormField::select('status_id', $issueStatuses::toArray(), ['label' => false, 'placeholder' => __('issue.all_status'), 'value' => request('status_id'), 'class' => 'form-control form-control-sm droplist']) !!}
    {{ Form::submit(__('app.filter'), ['class' => 'btn btn-info btn-sm p-2']) }}
    @if (request(['priority_id', 'status_id']))
        {{ link_to_route('issues.index', __('app.reset'), [], ['class' => 'btn btn-default']) }}
    @endif
    {{ Form::close() }}
    @can('create', new App\Models\ProjectManagement\Projects\Issue)
        {!! html_link_to_route('issues.create', __('issue.create'), [], ['class' => 'btn btn-warning btn-sm p-2', 'icon' => 'plus']) !!}
    @endcan
</div>
@endsection

@section('content')
<div id="project-issues" class="issue-table panel panel-default table-responsive">
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('issue.issues') }}</h3>
            </div>
            <div class="datatable mt-5 ml-3 mr-3">
            <div class="table-responsive">
                <table style="width: 100%;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--default-border-color);">
                    <th class="datatable-th">{{ __('app.table_no') }}</th>
                    <th class="datatable-th">{{ __('issue.title') }}</th>
                    <th class="datatable-th">{{ __('issue.priority') }}</th>
                    <th class="datatable-th">{{ __('app.status') }}</th>
                    <th class="datatable-th">{{ __('comment.comment') }}</th>
                    <th class="datatable-th">{{ __('issue.pic') }}</th>
                    <th class="datatable-th">{{ __('issue.creator') }}</th>
                    <th class="datatable-th">{{ __('app.last_update') }}</th>
                    <!-- <th>{{ __('issue.project') }}</th> -->
                    <th class="datatable-th">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($issues as $key => $issue)
                        @php
                            $no = 1 + $key;
                        @endphp
                        <tr style="border-bottom: 1px solid var(--default-border-color);" id="{{ $issue->id }}">
                            <td class="datatable-td">{{ $no }}</td>
                            <td class="datatable-td">{{ $issue->title }}</td>
                            <td class="datatable-td">{!! $issue->priority_label !!}</td>
                            <td class="datatable-td">{!! $issue->status_label !!}</td>
                            <td class="datatable-td">{{ $issue->comments_count }}</td>
                            <td class="datatable-td">{{ $issue->pic->name }}</td>
                            <td class="datatable-td">{{ $issue->creator->name }}</td>
                            <td class="datatable-td">{{ $issue->updated_at->diffForHumans() }}</td>
                            <!-- <td>{{ $issue->project->name }}</td> Display project name -->
                            <td class="datatable-td">
                                {{ link_to_route('issues.show', __('app.show'), [$issue], ['title' => __('issue.show')]) }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10">{{ __('issue.not_found') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $issues->links() }} <!-- Pagination links -->
        </div>
    </div>
</div>
@endsection
