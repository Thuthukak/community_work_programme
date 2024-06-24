@php
    $linkStyles = 'background-color: white; border-radius: 9999px; padding: 0.5rem 1rem; text-decoration: none; color: inherit; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);';
    $activeLinkStyles = 'background-color: #007bff; border-radius: 9999px; color: white;';
@endphp
<!-- Nav tabs -->
<ul style="display: flex; gap: 1rem; list-style: none; padding: 0; margin: 20;">
    <li class="nav-item" style="{{ Request::segment(3) == null ? $activeLinkStyles : '' }}">
        {!! link_to_route('jobs.show', __('job.detail'), $job, ['class' => 'nav-link', 'style' => $linkStyles . (Request::segment(3) == null ? $activeLinkStyles : '')]) !!}
    </li>
    @can('view-comments', $job)
    <li class="nav-item" style="{{ Request::segment(3) == 'comments' ? $activeLinkStyles : '' }}">
        {!! link_to_route('jobs.comments.index', __('comment.list').' ('.$job->comments->count().')', $job, ['class' => 'nav-link', 'style' => $linkStyles . (Request::segment(3) == 'comments' ? $activeLinkStyles : '')]) !!}
    </li>
    @endcan
</ul>
<br>
