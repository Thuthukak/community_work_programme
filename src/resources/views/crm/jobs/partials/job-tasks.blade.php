<div id="job-tasks" class="panel panel-default">
    <div class="panel-heading">
        @if (request('action') == 'sort_tasks')
            {{ link_to_route('jobs.show', __('app.done'), [$job], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin: -2px -8px']) }}
        @else
            <!-- {{ link_to_route('jobs.show', __('job.sort_tasks'), [$job, 'action' => 'sort_tasks', '#job-tasks'], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin: -2px -8px']) }} -->
        @endif
        <h3 class="panel-title">{{ request('action') == 'sort_tasks' ? __('job.sort_tasks') : __('job.tasks') }}</h3>
    </div>
    @if (request('action') == 'sort_tasks')
        <ul id="sort-tasks" class="list-group">
            @foreach($job->tasks as $key => $task)
                <li id="{{ $task->id }}" class="list-group-item">
                    <i class="fa fa-arrows-v" style="margin-right: 15px"></i> {{ $key + 1 }}. {{ $task->name }}
                </li>
            @endforeach
        </ul>
    @else
    <table class="table table-condensed">
        <thead>
            <th class="col-md-1 text-center">{{ __('app.table_no') }}</th>
            <th class="col-md-6">{{ __('task.name') }}</th>
            <th class="text-center col-md-1">{{ __('task.progress') }}</th>
            <th class="col-md-2 text-center">{{ __('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($job->tasks as $key => $task)
            <tr id="{{ $task->id }}">
                <td class="text-center">{{ 1 + $key }}</td>
                <td>
                    <div>{{ $task->name }}</div>
                    <div class="small text-info">{!! nl2br($task->description) !!}</div>
                </td>
                <td class="text-center">
                    <div class="progress-container">
                         <span class="progress-text ">{{ $task->progress }}%</span>
                            @can('update', $task)
                            @if ($task->progress < 100)
                                {!! FormField::formButton(['route' => ['tasks.set_done', $task], 'method' => 'patch'],
                                    __('task.set_done'),
                                    ['class' => 'btns btn-success btn-xs', 'id' => $task->id.'-set_task_done'],
                                    [
                                        'task_id' => $task->id,
                                        'project_job_id' => $task->project_job_id,
                                    ]
                                ) !!}
                            @endif
                            @endcan
                     </div>
                </td>

                <td class="text-center">
                @can('update', $task)
                    {!! html_link_to_route('jobs.show', '', [
                        $job,
                        'action' => 'task_edit',
                        'task_id' => $task->id
                    ],[
                        'class' => 'btn btn-warning btn-xs',
                        'title' => __('task.edit'),
                        'id' => $task->id . '-tasks-edit',
                        'icon' => 'edit'
                    ]) !!}
                @endcan
                @can('delete', $task)
                <a href="{{ route('jobs.show', [$job, 'action' => 'task_delete', 'task_id' => $task->id]) }}" 
           class="btn btn-danger btn-xs" 
           title="{{ __('task.delete') }}" 
           id="{{ $task->id . '-tasks-delete' }}">
            <svg width="16" height="16" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg" fill="#ffffff">
                <path d="M1490 1327q0 53-37 90t-90 37-90-37L896 1060l-377 357q-37 37-90 37t-90-37-37-90 37-90l357-377-357-377q-37-37-37-90t37-90 90-37 90 37l377 357 377-357q37-37 90-37t90 37 37 90-37 90L1060 896l357 377q37 37 37 90z"/>
            </svg>
        </a>
                @endcan
                </td>
            </tr>
            @empty
            <tr><td colspan="4">{{ __('task.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="2">{{ __('app.total') }}</th>
                <th class="text-center">{{ format_decimal($job->tasks->avg('progress')) }} %</th>
                <th>
                    @if (request('action') == 'sort_tasks')
                        {{ link_to_route('jobs.show', __('app.done'), [$job], ['class' => 'btn sort-task-btn btn-default btn-xs pull-right']) }}
                    @else
                        {{ link_to_route('jobs.show', __('job.sort_tasks'), [$job, 'action' => 'sort_tasks', '#job-tasks'], ['class' => 'btns btn-blue btn-xs pull-right']) }}
                    @endif
                </th>
            </tr>
        </tfoot>
    </table>
    @endif
</div>

@if (Request::has('action') == false)
@can('create', new App\Models\ProjectManagement\Projects\Task)
{{ Form::open(['route' => ['tasks.store', $job->id]]) }}
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">{{ __('task.create') }}</h3></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">{!! FormField::text('name', ['label' => __('task.name')]) !!}</div>
            <div class="col-md-4" style="margin-top: 32px;">
                {{ Form::label('progress', __('task.progress'), ['class' => 'control-label']) }}
                {{ Form::input('range', 'progress', 0, [
                    'min' => '0', 'max' => '100', 'step' => '10',
                ]) }}
            </div>
            <div class="col-md-2" style="font-size: 28px; margin-top: 23px;">
                <strong id="ap_weight">0</strong>%
            </div>
        </div>
        {!! FormField::textarea('description', ['label' => __('task.description')]) !!}
        {{ Form::submit(__('task.create'), ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
</div>
@endcan
@endif
@if (request('action') == 'sort_tasks')

@section('ext_js')
<script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
@endsection

@section('script')

<script>
(function() {
    $('#sort-tasks').sortable({
        update: function (event, ui) {
            var data = $(this).sortable('toArray').toString();
            // console.log(data);
            $.post("{{ route('jobs.tasks-reorder', $job->id) }}", {postData: data});
        }
    });
})();
</script>
@endsection

@endif
