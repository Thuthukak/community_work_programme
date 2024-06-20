@can('comment-on', $project)
{{ Form::open(['route' => ['projects.comments.store', $project]]) }}
<div class="row" style="margin:10px;">
    <div class="col-md-9">{!! FormField::textarea('body', ['required' => true, 'label' => false, 'placeholder' => __('comment.create_text'), 'class' => 'custom-formfield']) !!}</div>
    <div class="col-md-3" style="width: 10px;">
        {{ Form::submit(__('comment.create'), ['class' => 'btn btn-primary ']) }}<br>
    </div>
</div>
{{ Form::close() }}
@endcan
@foreach($comments as $comment)
<div class="alert alert-warning" style="margin:20px;">
    <legend style="font-size: 14px;margin-bottom: 10px;">
        <span class="label label-default pull-right">{{ $comment->time_display }}</span>
        <strong>{{ $comment->creator->name }}</strong>
    </legend>
    <div style="display: flex;justify-content: flex-start; gap: 10px">
        <div>
            <!-- @can('update', $comment)
                {{ link_to_route('projects.comments.index', __('app.edit'), [$project, 'action' => 'comment-edit', 'comment_id' => $comment->id], 
                    ['id' => 'edit-comment-'.$comment->id, 'class' => 'small', 'title' => __('comment.edit'),'icon' => 'edit']) }}
            @endcan -->
            @can('update', $comment)
                    {!! html_link_to_route('projects.comments.index', __('app.edit'), [
                        $project,
                        'action' => 'comment-edit',
                        'comment_id' => $comment->id
                    ],[
                        'class' => 'btn btn-warning btn-xs p-1',
                        'title' => __('comment.edit'),
                        'id' => $comment->id . '-edit-comment',
                        'icon' => 'edit'
                    ]) !!}
                @endcan
        </div>
        <div>
            <!-- @can('delete', $comment)
                {!! FormField::delete(
                    ['route' => ['projects.comments.destroy', $project, $comment], 'class' => ''],
                    '&times;',
                    ['class' => 'btn-link', 'id' => 'delete-comment-'.$comment->id],
                    ['comment_id' => $comment->id, 'page' => request('page')]
                ) !!}
            @endcan -->
            @can('delete', $comment)
            <a href="{{ route('projects.comments.destroy', ['project' => $project->id, 'comment' => $comment->id]) }}" 
                class="btn btn-danger btn-xs" 
                title="{{ __('comment.delete') }}" 
                id="delete-comment-{{ $comment->id }}">
                <svg width="16" height="16" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg" fill="#ffffff">
                <path d="M1490 1327q0 53-37 90t-90 37-90-37L896 1060l-377 357q-37 37-90 37t-90-37-37-90 37-90l357-377-357-377q-37-37-37-90t37-90 90-37 90 37l377 357 377-357q37-37 90-37t90 37 37 90-37 90L1060 896l357 377q37 37 37 90z"/>
                </svg>
            </a>
@endcan

        </div>
    </div><hr>
    <div style="margin-top: 10px;">
    {!! nl2br($comment->body) !!}
    </div>
</div>
@endforeach
