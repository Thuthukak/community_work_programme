<?php

namespace App\Http\Controllers\ProjectManagement\Jobs;

use App\Models\ProjectManagement\Projects\Comment;
use App\Models\ProjectManagement\Projects\ProjectJob;
use App\Http\Controllers\Controller;
use App\Models\CRM\Person\Person;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the job comments.
     *
     * @param  \App\Models\ProjectManagement\Projects\ProjectJob  $job
     * @return \Illuminate\View\View
     */
    public function index(ProjectJob $job)
    {
        $this->authorize('view-comments', $job);

        $editableComment = null;
        $comments = $job->comments()->with('creator')->latest()->paginate();

        if (request('action') == 'comment-edit' && request('comment_id') != null) {
            $editableComment = Comment::find(request('comment_id'));
        }


        return view('crm.jobs.comments', compact('job', 'comments', 'editableComment'));
    }

    /**
     * Store a new comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectManagement\Projects\ProjectJob  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, ProjectJob $job)
    {

        dd($job);

        $this->authorize('comment-on', $job);

        $newComment = $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $job->comments()->create([
            'body'       => $newComment['body'],
            'creator_id' => auth()->id(),
        ]);

        flash(__('comment.created'), 'success');

        return back();
    }

    /**
     * Update the specified comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectManagement\Projects\ProjectJob  $job
     * @param  \App\Entities\Jobs\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectJob $job, Comment $comment)
    {
        $this->authorize('update', $comment);

        $commentData = $request->validate([
            'body' => 'required|string|max:255',
        ]);
        $comment->update($commentData);
        flash(__('comment.updated'), 'success');

        return redirect()->route('jobs.comments.index', [$job] + request(['page']));
    }

    /**
     * Remove the specified comment.
     *
     * @param  \App\Entities\Jobs\Comment  $comment
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(ProjectJob $job, Comment $comment)
    {
        $this->authorize('delete', $comment);

        request()->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        if (request('comment_id') == $comment->id && $comment->delete()) {
            $routeParam = [$job] + request(['page']);
            flash(__('comment.deleted'), 'warning');

            return redirect()->route('jobs.comments.index', $routeParam);
        }
        flash(__('comment.undeleted'), 'error');

        return back();
    }
}
