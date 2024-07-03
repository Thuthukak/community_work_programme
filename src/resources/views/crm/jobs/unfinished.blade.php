@extends('layouts.crm')

@section('title', __('job.on_progress'))

@section('contents')

<ul class="breadcrumb hidden-print header-pill"><li>{{ __('job.on_progress') }}</li></ul>


<div class="panel panel-default table-responsive">
    <div class="filter-heading panel-heading">
        {{ Form::open(['method' => 'get', 'class' => 'form-inline']) }}
        {!! FormField::select('project_id', $projects, ['label' => __('project.select'), 'placeholder' => __('project.all'),'class' => 'mr-2']) !!}
        {{ Form::submit(__('app.filter'), ['class' => 'btn btn-info btn-m mr-1 filter-task-progress']) }}
        {{ link_to_route('jobs.index', __('app.reset'), [], ['class' => 'btn btn-danger p-2 mr-1 btn-sm filter-task-progress']) }}
        {{ Form::close() }}
    </div>
    <div class="table-wrapper shadow" style="margin:20px">
    <table class="task-progress-table table table-condensed">
        <thead>
            <th>{{ __('app.table_no') }}</th>
            <th>{{ __('project.name') }}</th>
            <th>{{ __('job.name') }}</th>
            <th class="text-center">{{ __('job.tasks_count') }}</th>
            <th class="text-center">{{ __('job.progress') }}</th>
            @can('see-pricings', new App\Models\ProjectManagement\Projects\ProjectJob)
            <th class="text-right">{{ __('job.price') }}</th>
            @endcan
            <th>{{ __('job.person') }}</th>
            <th>{{ __('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($jobs as $key => $job)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>{{ $job->project->nameLink() }}</td>
                <td>
                    {{ $job->nameLink() }}
                    @if ($job->tasks->isEmpty() == false)
                    <ul>
                        @foreach($job->tasks as $task)
                        <li style="cursor:pointer" title="{{ $task->progress }} %">
                            <i class="fa fa-battery-{{ ceil(4 * $task->progress/100) }}"></i>
                            {{ $task->name }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td class="text-center">{{ $job->tasks_count = $job->tasks->count() }}</td>
                <td class="text-center">{{ format_decimal($job->progress) }} %</td>
                @can('see-pricings', $job)
                <td class="text-right">{{ format_money($job->price) }}</td>
                @endcan
                <td>{{ $job->person->name }}</td>
                <td>
                    {{ link_to_route('jobs.show', __('app.show'), [$job], ['class' => 'btn btn-info btn-xs']) }}
                </td>
            </tr>
            @empty
            <tr><td colspan="8">{{ __('job.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="3">{{ __('app.total') }}</th>
                <th class="text-center">{{ $jobs->sum('tasks_count') }}</th>
                <th class="text-center">{{ format_decimal($jobs->avg('progress')) }} %</th>
                @can('see-pricings', new App\Models\ProjectManagement\Projects\ProjectJob)
                <th class="text-right">{{ format_money($jobs->sum('price')) }}</th>
                @endcan
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div> 
</div>
@endsection
