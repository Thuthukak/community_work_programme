<?php

namespace App\Http\Controllers\ProjectManagement\Jobs;

use App\Models\ProjectManagement\Projects\Comment;
use App\Models\ProjectManagement\Projects\ProjectJob;
use App\Http\Controllers\Controller;
use App\Models\CRM\Person\Person;
use App\Models\CRM\Ticket\traits\EmailTrait;
use App\Mail\AppMailer;
use Illuminate\Http\Request;

class CommentsController extends Controller
{



    use EmailTrait;

    public function postComment(Request $request, AppMailer $mailer)
	{
	    $this->validate($request, [
	        'comment'   => 'required'
	    ]);

	    $ticketId = $request->input('ticket_id');
	    $comment = $request->input('comment');
	    $status = $request->input('status');

        $authUser = Auth::user();

        $comment = Comment::create([
            'ticket_id' => $ticketId,
            'user_id'   => $authUser->id,
            'comment'   => $comment,
        ]);
        $ticket = Ticket::with('department')->find($ticketId);
        if ($status == 'Closed'){
            $ticket->update(['status' => 'Closed']);
        }else{
            $ticket->update(['status' => 'Open']);
        }
        $deptUser = Department::with('user')->findOrFail($ticket->department->id);

        $ticketOwner = $comment->ticket->user;
        $subject = "RE: $ticket->title (Ticket ID: $ticket->ticket_id)";
        $details = ['title' => $subject, 'ticket_id' => $ticket->ticket_id];

        // send mail if the user commenting is not the ticket owner
        if ($comment->ticket->user->id !== $authUser->id) {
            $mailText = $this->commentTemplate($authUser, $ticket,$subject, $comment);
            $mailer->sendEmail($mailText, $ticketOwner->email,$subject);
            // send notification
            $ticketOwner->notify(new TicketNotification($details));
        } else{
            if ($deptUser->user->isNotEmpty()){
                $deptUser->user[0]->notify(new TicketNotification($details));
            }else{
                $authUser->isAdmin()->notify(new TicketNotification($details));
            }
        }

        $notify = updateNotify('Your comment has been submitted');

        return redirect()->back()->with($notify);
	}
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
