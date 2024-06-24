@php
    $queryStrings = request(['q']);
    $routeName = $routeName ?? 'projects.index';

    $linkStyles = 'background-color: white; border-radius: 9999px; padding: 0.5rem 1rem; text-decoration: none; color: inherit; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);';
    $activeLinkStyles = 'background-color: #007bff; color: white; border-radius: 9999px';
@endphp
<!-- Nav tabs -->
<ul style="display: flex; gap: 1rem; list-style: none; padding: 0; margin: 20;">
    <li style="{{ request('status_id') == null ? $activeLinkStyles : '' }}">
        {{ link_to_route($routeName, __('project.all'), $queryStrings, ['title' => __('project.all'), 'style' => $linkStyles . (request('status_id') == null ? $activeLinkStyles : '')]) }}
    </li>
    <li style="{{ request('status_id') == 1 ? $activeLinkStyles : '' }}">
        {{ link_to_route($routeName, __('project.planned'), ['status_id' => 1] + $queryStrings, ['title' => __('project.planned'), 'style' => $linkStyles . (request('status_id') == 1 ? $activeLinkStyles : '')]) }}
    </li>
    <li style="{{ request('status_id') == 2 ? $activeLinkStyles : '' }}">
        {{ link_to_route($routeName, __('project.progress'), ['status_id' => 2] + $queryStrings, ['title' => __('project.progress'), 'style' => $linkStyles . (request('status_id') == 2 ? $activeLinkStyles : '')]) }}
    </li>
    <li style="{{ request('status_id') == 3 ? $activeLinkStyles : '' }}">
        {{ link_to_route($routeName, __('project.done'), ['status_id' => 3] + $queryStrings, ['title' => __('project.done'), 'style' => $linkStyles . (request('status_id') == 3 ? $activeLinkStyles : '')]) }}
    </li>
    <li style="{{ request('status_id') == 4 ? $activeLinkStyles : '' }}">
        {{ link_to_route($routeName, __('project.closed'), ['status_id' => 4] + $queryStrings, ['title' => __('project.closed'), 'style' => $linkStyles . (request('status_id') == 4 ? $activeLinkStyles : '')]) }}
    </li>
    <li style="{{ request('status_id') == 5 ? $activeLinkStyles : '' }}">
        {{ link_to_route($routeName, __('project.canceled'), ['status_id' => 5] + $queryStrings, ['title' => __('project.canceled'), 'style' => $linkStyles . (request('status_id') == 5 ? $activeLinkStyles : '')]) }}
    </li>
    <li style="{{ request('status_id') == 6 ? $activeLinkStyles : '' }}">
        {{ link_to_route($routeName, __('project.on_hold'), ['status_id' => 6] + $queryStrings, ['title' => __('project.on_hold'), 'style' => $linkStyles . (request('status_id') == 6 ? $activeLinkStyles : '')]) }}
    </li>
</ul>
