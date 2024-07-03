@extends('crm.layouts.project')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.css">

@section('subtitle', __('project.jobs'))

@section('action-buttons')


@can('create', new App\Models\ProjectManagement\Projects\ProjectJob)
<div class="action-buttons-container" style="margin-left:1250px">

<div class="create-project-btn ml-auto">
<button class="btn btn-warning btn-sm p-2" data-toggle="modal" data-target="#createTaskModal" data-project-id="{{ $project->id }}">{{ trans('Add Task') }}</button>
    {!! html_link_to_route('projects.jobs.add-from-other-project', __('job.add_from_other_project'), [$project], ['class' => 'btn btn-success btn-sm p-2 mr-4', 'icon' => 'plus']) !!}
</div>
</div>
    @endcan

@endsection

@section('content-project')

@if ($jobs->isEmpty())
<p class="no-task">{{ __('project.no_jobs') }},
<div class="create-project-btn ml-auto">
<a href="#" class="btn btn-warning btn-sm p-2"
   data-toggle="modal"
   data-target="#createTaskModal"
   data-project-id="{{ $project->id }}">
   {{ trans('Add Task') }}
</a>
</div></p>
@else

@foreach($jobs->groupBy('type_id') as $key => $groupedJobs)
<div id="project-jobs" class="task-header flex justify-between items-center mb-4">
    <div class="task-panel-heading">
    <div class="wrap-action-btns">
        <div class="action-btns-container2 pill-container">
            @can('update', $project)
                @if (request('action') == 'sort_jobs')
                    {{ link_to_route('projects.jobs.index', __('app.done'), [$project], ['class' => 'btn btn-default btn-xs pull-right', 'style' => 'margin-top: 0px; margin-left: 6px; margin-right: -8px']) }} 
                @else
                    {{ link_to_route('projects.jobs.index', __('project.sort_jobs'), [$project, 'action' => 'sort_jobs', '#project-jobs'], ['class' => 'btn btn-default mr-1 p-1 btn-xs', 'style' => 'margin-top: -2px; margin-left: 6px; margin-right: -8px']) }} |
                    @can('see-pricings', $project)
                    {!! link_to_route('projects.jobs-export', __('project.jobs_list_export_html'), [$project, 'html', 'job_type' => $key], ['class' => '', 'target' => '_blank']) !!} |
                    {!! link_to_route('projects.job-progress-export', __('project.jobs_progress_export_html'), [$project, 'html', 'job_type' => $key], ['class' => '', 'target' => '_blank']) !!}
                    @endcan
                @endif
            @endcan
        </div>
    </div>
        <h3 class="panel-title custom-text-muted" style="margin-left: -40px">
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
<div class="table-wrapper shadow" style="margin-left:-10px">
    <div class=" panel-body table-responsive">
        <table class="table table-condensed  table-hover">
            <thead class="custom-th2">
                <th>{{ __('app.table_no') }}</th>
                <th>{{ __('job.name') }}</th>
                <th class="text-center">{{ __('job.tasks_count') }}</th>
                <th class="text-center">{{ __('job.progress') }}</th>
                @can('see-pricings', new App\Models\ProjectManagement\Projects\ProjectJob)
                <th class="text-right">{{ __('job.price') }}</th>
                @endcan
                {{-- <th>{{ __('job.person') }}</th> --}}
                <th class="text-center">{{ __('time.updated_at') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </thead>
            <tbody>
                @forelse($groupedJobs as $key => $job)
                @php
                $no = 1 + $key;
                $job->progress = $job->tasks->avg('progress');
                @endphp
                <tr id="{{ $job->id }}" {!! $job->progress <= 50 ? 'style="background-color:#f1d9d9"' : '' !!}>
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
                    <td class="text-center">{{ ($job->progress) }} %</td>
                    @can('see-pricings', $job)
                    <td class="text-right">{{ format_money($job->price) }}</td>
                    @endcan
                    <td class="text-center">
                        {{ $job->updated_at->diffForHumans() }} <br>
                        {{ __('job.person') }} : {{ $job->person->name }}
                    </td>
                    <td class="text-center">
                        @can('view', $job)
                        {!! html_link_to_route('jobs.show', '',[$job->id],['icon' => 'search', 'title' => __('job.show'), 'class' => 'btn btn-info btn-xs', 'id' => 'show-job-' . $job->id]) !!}
                        @endcan
                        @can('edit', $job)
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
                                {{ link_to_route('projects.jobs.index', __('project.sort_jobs'), [$project->id, 'action' => 'sort_jobs', '#project-jobs'], ['class' => 'btn sort-job-btn p-1 m1-10 btn-default btn-xs']) }}
                            @endif
                        @endcan
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
    @endif
</div>
@endforeach

@endif


<!-- Create task modal -->
<div id="createTaskModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add Task') }}</h4>
            </div>
            {!! Form::open(['route' => ['projects.jobs.store', $project->id], 'method' => 'POST']) !!}
            <div class="modal-body">
                {!! FormField::text('name', ['label' => trans('job.name')]) !!}
                {!! FormField::textarea('description', ['label' => __('job.description')]) !!}
                <div class="row">
                    <div class="col-sm-4">
                        {!! FormField::price('price', [
                            'label'    => __('job.price'),
                            'currency' => Option::get('money_sign', 'Rp'),
                            'value'    => 0,
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::select('person_id', $person, ['label' => __('Assign to'), 'value' => 1]) !!}
                    </div>
                    <div class="col-sm-4">
                        {!! FormField::radios('type_id', [1 => __('job.main'), __('job.additional')], ['value' => 1, 'label' => __('job.type'), 'list_style' => 'unstyled']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('target_start_date', ['label' => __('job.target_start_date'), 'class' => 'date-select']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::text('target_end_date', ['label' => __('job.target_end_date'), 'class' => 'date-select']) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{ Form::submit(__('Save'), ['class' => 'btn btn-primary']) }}
                {{ link_to_route('projects.jobs.index', __('app.cancel'), [$project], ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>



@endsection


@can('update', $project)
@if (request('action') == 'sort_jobs')

@section('ext_js')
    <script src="assets/js/plugins/jquery-ui.min.js'"></script>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

<script>
 document.addEventListener('DOMContentLoaded', function() {
        // Initialize Sortable on the .sort-jobs element
        const sortJobs = new Sortable(document.querySelector('.sort-jobs'), {
        onUpdate: function(evt) {
            // Get sorted item IDs
            const itemIds = sortJobs.toArray();

            // AJAX post request to reorder jobs
            fetch('{{ route('projects.jobs-reorder', $project->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                },
                body: JSON.stringify({ postData: itemIds })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                console.log('Jobs reordered successfully');
            })
            .catch(error => {
                console.error('Error reordering jobs:', error);
            });
        }
    });

    });
</script>
@endsection

@endif
@endcan

@section('script')
<!-- Include Flatpickr JS from cdnjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize Flatpickr on the date input fields with class date-select
    flatpickr(".date-select", {
        dateFormat: "Y-m-d",
        disableMobile: true // optional: to force the desktop version on mobile devices
    });



});

        </script>

@endsection

