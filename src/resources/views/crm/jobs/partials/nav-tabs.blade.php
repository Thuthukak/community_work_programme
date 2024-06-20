<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }} nav-item">
        {!! link_to_route('jobs.show', __('job.detail'), $job, ['class' => 'nav-link custom-nav-link']) !!}
    </li>
    @can('view-comments', $job)
    <li class="{{ Request::segment(3) == 'comments' ? 'active' : '' }} nav-item">
        {!! link_to_route('jobs.comments.index', __('comment.list').' ('.$job->comments->count().')', $job, ['class' => 'nav-link custom-nav-link']) !!}
    </li>
    @endcan
</ul>
<br>
