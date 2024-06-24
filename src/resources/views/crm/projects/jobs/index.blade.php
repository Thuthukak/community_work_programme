@extends('crm.layouts.project')

@section('subtitle', __('project.jobs'))

@section('action-buttons')


@can('create', new App\Models\ProjectManagement\Projects\ProjectJob)
<div class="action-buttons-container" style="display: flex;
    justify-content: flex-end;
    margin-right: 20px;">
    {!! html_link_to_route('projects.jobs.create', __('job.create'), [$project], ['class' => 'btn btn-primary btn-sm p-2 mr-2', 'icon' => 'plus']) !!}
    {!! html_link_to_route('projects.jobs.add-from-other-project', __('job.add_from_other_project'), [$project], ['class' => 'btn btn-success btn-sm p-2 mr-4', 'icon' => 'plus']) !!}
</div>
    @endcan

@endsection

@section('content-project')

@if ($jobs->isEmpty())
<p class="no-task" style="margin: 20px;">{{ __('project.no_jobs') }},
    {{ link_to_route('projects.jobs.create', __('job.create'), [$project]) }}.
</p>
@else

@foreach($jobs->groupBy('type_id') as $key => $groupedJobs)

<div id="project-jobs" class="task-header flex justify-between items-center mb-4" stye="margin: 30px 60px 30px 30px;">
    <div class="task-panel-heading" style="margin: 30px 60px 30px 30px;">
    <div class="wrap-action-btns" style="display: flex;
     justify-content: flex-end;
     width: 100%; 
     margin-left: 40px;" >
        <div class="action-btns-container2 pill-container" style="display: flex;
    gap: 10px; width: fit-content;
    height: 50px;
    display: flex;
    align-items: center;
    padding: 10px;
    justify-content: flex-end;
    background-color: white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 50px; ">
            @can('update', $project)
                @if (request('action') == 'sort_jobs')
                    {{ link_to_route('projects.jobs.index', __('app.done'), [$project], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin-top: 0px; margin-left: 6px; margin-right: -8px']) }}
                @else
                    {{ link_to_route('projects.jobs.index', __('project.sort_jobs'), [$project, 'action' => 'sort_jobs', '#project-jobs'], ['class' => 'btn btn-info mr-1 p-1 btn-xs', 'style' => 'margin-top: -3px; margin-left: 6px; margin-right: -8px']) }}
                    @can('see-pricings', $project)
                    {!! link_to_route('projects.jobs-export', __('project.jobs_list_export_html'), [$project, 'html', 'job_type' => $key], ['class' => '', 'target' => '_blank']) !!} |
                    {!! link_to_route('projects.job-progress-export', __('project.jobs_progress_export_html'), [$project, 'html', 'job_type' => $key], ['class' => '', 'target' => '_blank']) !!}
                    @endcan
                @endif
            @endcan
        </div>
    </div>
        <h3 class="panel-title" style="margin-left: -20px">
            {{ $key == 1 ? __('project.jobs') : __('project.additional_jobs') }}
            @if (request('action') == 'sort_jobs')
            <em>: {{ __('project.sort_jobs') }}</em>
            @endif
        </h3>
    </div>
    @if (request('action') == 'sort_jobs')
        <ul class="sort-jobs list-group">
            @foreach($groupedJobs as $key => $job)
                <li id="{{ $job->id }}" class="list-group-item">
                    <i class="fa fa-arrows-v" style="margin-right: 15px"></i> {{ $key + 1 }}. {{ $job->name }}
                </li>
            @endforeach
        </ul>
    @else
    <div class=" panel-body table-responsive">
        <table class="table table-condensed  table-hover" style="background: white;
    padding:2px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    padding-bottom: 50px;
    margin:10px;">
            <thead>
                <th>{{ __('app.table_no') }}</th>
                <th>{{ __('job.name') }}</th>
                <th class="text-center">{{ __('job.tasks_count') }}</th>
                <th class="text-center">{{ __('job.progress') }}</th>
                @can('see-pricings', new App\Models\ProjectManagement\Projects\ProjectJob)
                <th class="text-right">{{ __('job.price') }}</th>
                @endcan
                {{-- <th>{{ __('job.worker') }}</th> --}}
                <th class="text-center">{{ __('time.updated_at') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </thead>
            <tbody>
                @forelse($groupedJobs as $key => $job)
                @php
                $no = 1 + $key;
                $job->progress = $job->tasks->avg('progress');
                @endphp
                <tr id="{{ $job->id }}" {!! $job->progress <= 50 ? 'style="background-color:#f4f3f3"' : '' !!}>
                    <td>{{ $no }}</td>
                    <td>
                        {{ $job->name }}
                        @if ($job->tasks->isEmpty() == false)
                        <ul>
                            @foreach($job->tasks as $task)
                            <li>{{ $task->name }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </td>
                    <td class="text-center">{{ $job->tasks_count = $job->tasks->count() }}</td>
                    <td class="text-center">{{ format_decimal($job->progress) }} %</td>
                    @can('see-pricings', $job)
                    <td class="text-right">{{ format_money($job->price) }}</td>
                    @endcan
                    <td class="text-center">
                        {{ $job->updated_at->diffForHumans() }} <br>
                        {{ __('job.worker') }} : {{ $job->worker->name }}
                    </td>
                    <td class="text-center">
                        @can('view', $job)
                        {!! html_link_to_route('jobs.show', '',[$job->id],['icon' => 'search', 'title' => __('job.show'), 'class' => 'btn btn-info btn-xs', 'id' => 'show-job-' . $job->id]) !!}
                        @endcan
                        @can('edit', $job)
                        {!! html_link_to_route('jobs.edit', '',[$job->id],['icon' => 'edit', 'title' => __('job.edit'), 'class' => 'btn btn-warning btn-xs']) !!}
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">{{ __('job.empty') }}</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right" colspan="2">Total</th>
                    <th class="text-center">{{ $groupedJobs->sum('tasks_count') }}</th>
                    <th class="text-center">
                        <span title="Total Progress">{{ format_decimal($groupedJobs->sum('progress') / $groupedJobs->count()) }} %</span>
                        <span title="Overal Progress" style="font-weight:300">({{ format_decimal($project->getJobOveralProgress()) }} %)</span>
                    </th>
                    @can('see-pricings', new App\Models\ProjectManagement\Projects\ProjectJob)
                    <th class="text-right">{{ format_money($groupedJobs->sum('price')) }}</th>
                    @endcan
                    <th colspan="2">
                        @can('update', $project)
                            @if (request('action') == 'sort_jobs')
                                {{ link_to_route('projects.jobs.index', __('app.done'), [$project->id], ['class' => 'btn btn-default btn-xs pull-right']) }}
                            @else
                                {{ link_to_route('projects.jobs.index', __('project.sort_jobs'), [$project->id, 'action' => 'sort_jobs', '#project-jobs'], ['class' => 'btn sort-job-btn p-1 btn-default btn-xs']) }}
                            @endif
                        @endcan
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif
</div>
@endforeach

@endif
@endsection

@can('update', $project)
@if (request('action') == 'sort_jobs')

@section('ext_js')
<script src="{{ url('assets/js/plugins/jquery-ui.min.js') }}"></script>
@endsection

@section('script')

<script>
(function() {
    $('.sort-jobs').sortable({
        update: function (event, ui) {
            var data = $(this).sortable('toArray').toString();
            $.post("{{ route('projects.jobs-reorder', $project->id) }}", {postData: data});
        }
    });
})();
</script>
@endsection

@endif
@endcan
