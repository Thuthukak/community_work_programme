@inject('priorities', 'App\Models\ProjectManagement\Projects\Priority')
@inject('issueStatuses', 'App\Models\ProjectManagement\Projects\IssueStatus')
@inject('projects', 'App\Models\ProjectManagement\Projects\Project') 

@extends('layouts.crm')

@section('title', __('issue.open_issues'))

@section('contents')

<ul class="breadcrumb hidden-print"><li>{{ __('issue.issues_on_progress') }}</li></ul>

<div class="panel panel-default table-responsive">
    <div class="filter-heading panel-heading">

    </div>
    <table class="task-progress-table table table-condensed">
        <thead>
            <tr>
                <th>{{ __('app.table_no') }}</th>
                <th>{{ __('issue.title') }}</th>
                <th>{{ __('issue.priority') }}</th>
                <th>{{ __('app.status') }}</th>
                <th class="text-center">{{ __('Project') }}</th>
                <th>{{ __('issue.pic') }}</th>
                <th>{{ __('issue.creator') }}</th>
                <th>{{ __('app.last_update') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($issues as $key => $issue)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $issue->title }}</td>
                    <td>{!! $issue->priority_label !!}</td>
                    <td class="text-black">{!! $issue->status_label !!}</td>
                    <td>

                    </td>
                    <td>{{ $issue->pic->name }}</td>
                    <td>{{ $issue->creator->name }}</td>
                    <td>{{ $issue->updated_at->diffForHumans() }}</td>
                    <td class="text-center">
                      
                    </td>
                </tr>
            @empty
                <tr><td colspan="9">{{ __('issue.not_found') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <!-- Adjust your footer as needed -->
        </tfoot>
    </table>
</div>

@endsection
