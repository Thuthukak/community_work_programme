<ul class="breadcrumb hidden-print" style="display: flex;
    justify-content: flex-start;
    gap: 20px;
    align-items: center;
    margin: 20px;">
    <li>{{ link_to_route('projects.index', __('project.projects')) }}</li>
    <li>{{ $job->present()->projectLink }}</li>
    <li>{{ $job->present()->projectJobsLink }}</li>
    <li class="active">{{ isset($title) ? $title : $job->name }}</li>
</ul>
