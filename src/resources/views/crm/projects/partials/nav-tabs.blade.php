@php
    $linkStyles = 'background-color: white; border-radius: 9999px; padding: 0.5rem 1rem; text-decoration: none; color: inherit; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);';
    $activeLinkStyles = 'background-color: #007bff; border-radius: 9999px; color: white;';
@endphp
<!-- Nav tabs -->
<ul style="display: flex; gap: 1rem; list-style: none; padding: 0; margin: 20;">
    <li class="nav-item" style="{{ Request::segment(3) == null ? $activeLinkStyles : '' }}">
        {!! link_to_route('projects.show', __('project.detail'), $project, ['class' => 'nav-link', 'style' => $linkStyles . (Request::segment(3) == null ? $activeLinkStyles : '')]) !!}
    </li>

    <!-- <li class="nav-item" style="{{ Request::segment(3) == 'activities' ? $activeLinkStyles : '' }}">
        {!! link_to_route('projects.activities.index', __('project.activities'), $project, ['class' => 'nav-link', 'style' => $linkStyles . (Request::segment(3) == 'activities' ? $activeLinkStyles : '')]) !!}
    </li> -->
    
    @can('view-jobs', $project)
    <li class="nav-item" style="{{ Request::segment(3) == 'jobs' ? $activeLinkStyles : '' }}">
        {!! link_to_route('projects.jobs.index', __('project.jobs').' ('.$project->jobs->count().')', $project, ['class' => 'nav-link', 'style' => $linkStyles . (Request::segment(3) == 'jobs' ? $activeLinkStyles : '')]) !!}
    </li>
    @endcan
    
    <li class="nav-item" style="{{ Request::segment(3) == 'issues' ? $activeLinkStyles : '' }}">
        {!! link_to_route('projects.issues.index', __('project.issues').' ('.$project->issues->count().')', $project, ['class' => 'nav-link', 'style' => $linkStyles . (Request::segment(3) == 'issues' ? $activeLinkStyles : '')]) !!}
    </li>
    
    @can('view-comments', $project)
    <li class="nav-item" style="{{ Request::segment(3) == 'comments' ? $activeLinkStyles : '' }}">
        {!! link_to_route('projects.comments.index', __('comment.list').' ('.$project->comments->count().')', $project, ['class' => 'nav-link', 'style' => $linkStyles . (Request::segment(3) == 'comments' ? $activeLinkStyles : '')]) !!}
    </li>
    @endcan
    
    <!-- @can('view-subscriptions', $project)
    <li class="nav-item" style="{{ Request::segment(3) == 'subscriptions' ? $activeLinkStyles : '' }}">
        {!! link_to_route('projects.subscriptions', __('project.subscriptions').' ('.$project->subscriptions->count().')', $project, ['class' => 'nav-link', 'style' => $linkStyles . (Request::segment(3) == 'subscriptions' ? $activeLinkStyles : '')]) !!}
    </li>
    @endcan -->
    
    @can('view-files', $project)
    <li class="nav-item" style="{{ Request::segment(3) == 'files' ? $activeLinkStyles : '' }}">
        {!! link_to_route('projects.files', __('project.files').' ('.$project->files->count().')', $project, ['class' => 'nav-link', 'style' => $linkStyles . (Request::segment(3) == 'files' ? $activeLinkStyles : '')]) !!}
    </li>
    @endcan
</ul>
