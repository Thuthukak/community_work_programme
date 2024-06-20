<!-- Nav tabs -->
<ul class="nav nav-tabs ">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }} nav-item">
        {!! link_to_route('projects.show', __('project.detail'), $project, ['class' => 'nav-link']) !!}
    </li>
        {!! link_to_route('projects.activities.index', __('project.activities'), $project, ['class' => 'nav-link']) !!}
    </li> -->
    <!-- <li class="{{ Request::segment(3) == 'activities' ? 'active' : '' }} nav-item">
    @can('view-jobs', $project)
    <li class="{{ Request::segment(3) == 'jobs' ? 'active' : '' }} nav-item">
        {!! link_to_route('projects.jobs.index', __('project.jobs').' ('.$project->jobs->count().')', $project, ['class' => 'nav-link']) !!}
    </li>
    @endcan
    <li class="{{ Request::segment(3) == 'issues' ? 'active' : '' }} nav-item">
        {!! link_to_route('projects.issues.index', __('project.issues').' ('.$project->issues->count().')', $project, ['class' => 'nav-link']) !!}
    </li>
    @can('view-comments', $project)
    <li class="{{ Request::segment(3) == 'comments' ? 'active' : '' }} nav-item">
        {!! link_to_route('projects.comments.index', __('comment.list').' ('.$project->comments->count().')', $project, ['class' => 'nav-link']) !!}
    </li>
    @endcan
    <!-- @can('view-subscriptions', $project)
    <li class="{{ Request::segment(3) == 'subscriptions' ? 'active' : '' }} nav-item">
        {!! link_to_route('projects.subscriptions', __('project.subscriptions').' ('.$project->subscriptions->count().')', $project, ['class' => 'nav-link']) !!}
    </li>
    @endcan -->
    @can('view-files', $project)
    <li class="{{ Request::segment(3) == 'files' ? 'active' : '' }} nav-item">
        {!! link_to_route('projects.files', __('project.files').' ('.$project->files->count().')', $project, ['class' => 'nav-link']) !!}
    </li>
    @endcan
</ul>
