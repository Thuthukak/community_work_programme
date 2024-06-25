@extends('crm.layouts.project')

@section('subtitle', __('issue.detail'))

@section('action-buttons')
@can('create', new App\Models\ProjectManagement\Projects\Issue)
    {!! html_link_to_route('projects.issues.create', __('issue.create'), $project, ['class' => 'btn btn-success', 'icon' => 'plus']) !!}
@endcan
@endsection

@section('content-project')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-right">{!! $issue->status_label !!}</div>
                    {{ __('issue.detail') }}
                </h3>
            </div>
            <table class="table table-condensed">
                <tbody>
                    <tr><th class="col-md-4">{{ __('issue.title') }}</th><td class="col-md-8">{{ $issue->title }}</td></tr>
                    <tr><th>{{ __('issue.body') }}</th><td>{{ $issue->body }}</td></tr>
                    <tr><th>{{ __('issue.priority') }}</th><td>{!! $issue->priority_label !!}</td></tr>
                    <tr><th>{{ __('issue.pic') }}</th><td>{{ $issue->pic->name }}</td></tr>
                    <tr><th>{{ __('app.created_by') }}</th><td>{{ $issue->creator->name }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                <button class="btn btn-warning btn-sm p-2" data-toggle="modal" data-target="#EditIssueModal">{{ trans('Edit Issue') }}</button>
                {{ link_to_route('projects.issues.index', __('issue.back_to_index'), [$project], ['class' => 'btn btn-default pull-right']) }}
            </div>
        </div>
        <hr>
        @include('crm.projects.issues.partials.comment-section')
    </div>
    <div class="col-md-6">
        {{ Form::model($issue, ['route' => ['issues.options.update', $issue], 'method' => 'patch']) }}
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('app.action') }}</h3></div>
            <div class="panel-body">
                {!! FormField::radios('priority_id', $priorities, ['label' => __('issue.priority')]) !!}
                {!! FormField::radios('status_id', $statuses, ['label' => __('app.status')]) !!}
                {!! FormField::select('pic_id', $users, ['label' => __('issue.assign_pic'), 'placeholder' => __('issue.select_pic')]) !!}
            </div>
            <div class="panel-footer">
                {{ Form::submit(__('issue.update'), ['class' => 'btn btn-success']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

<!-- Edit Modal -->
<div id="EditIssueModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Edit Issue') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::model($issue, ['route' => ['projects.issues.update', $project->id, $issue->id], 'method' => 'patch']) !!}
            <div class="modal-body">
                <div class="panel-heading"><h3 class="panel-title">{{ __('issue.update') }}</h3></div>
                <div class="panel-body">
                    {!! FormField::text('title', ['label' => __('issue.title')]) !!}
                    {!! FormField::textarea('body', ['label' => __('issue.body')]) !!}
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::submit(trans('Save'), ['class' => 'btn btn-success']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.cancel') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
(function () {
    $('#commentModal').modal({
        show: true,
        backdrop: 'static',
    });
})();
</script>
@endsection
