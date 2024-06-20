<?php

namespace App\Http\Controllers\ProjectManagement;

use App\Models\ProjectManagement\Projects\Comment;
use App\Models\ProjectManagement\Projects\Issue;
use App\Models\ProjectManagement\Projects\IssueStatus;
use App\Models\ProjectManagement\Projects\Priority;
use App\Models\ProjectManagement\Projects\Project;
use App\Models\Core\Auth\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index()
    {
        $issueQuery = Issue::orderBy('updated_at', 'desc')
            ->with(['pic', 'creator', 'project']) // Include related projects
            ->withCount(['comments']);

        if ($priorityId = request('priority_id')) {
            $issueQuery->where('priority_id', $priorityId);
        }

        if ($statusId = request('status_id')) {
            $issueQuery->where('status_id', $statusId);
        }

        $issues = $issueQuery->paginate(10);
        $priorities = Priority::toArray();
        $issueStatuses = IssueStatus::toArray();

        return view('crm.projects.issues.indexs', compact('issues', 'priorities', 'issueStatuses','project'));
    }
 

    public function create()
    {
        $projects = Project::pluck('name', 'id');
        $users = User::pluck('first_name', 'id');
        $priorities = Priority::toArray();

        return view('crm.projects.issues.create', compact('projects', 'users', 'priorities'));
    }

    public function store(Request $request)
    {
        $issueData = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|max:60',
            'body'        => 'required|max:255',
            'priority_id' => 'required|in:1,2,3',
            'pic_id'      => 'nullable|exists:users,id',
        ]);

        Issue::create([
            'project_id'  => $issueData['project_id'],
            'creator_id'  => auth()->id(),
            'title'       => $issueData['title'],
            'body'        => $issueData['body'],
            'priority_id' => $issueData['priority_id'],
            'pic_id'      => $issueData['pic_id'],
        ]);

        flash(__('issue.created'), 'success');

        return redirect()->route('issues.index');
    }

    public function show(Issue $issue)
    {
        $editableComment = null;
        $priorities = Priority::toArray();
        $statuses = IssueStatus::toArray();
        $users = User::pluck('first_name', 'id');
        $comments = $issue->comments()->with('creator')->get();
        $project = $issue->project;

        if (request('action') == 'comment-edit' && request('comment_id') != null) {
            $editableComment = Comment::find(request('comment_id'));
        }

        return view('crm.projects.issues.show', compact(
            'project', 'issue', 'users', 'statuses', 'priorities', 'comments',
            'editableComment'
        ));
    }

    public function edit(Issue $issue)
    {
        $project = $issue->project;
        return view('crm.projects.issues.edit', compact('project', 'issue'));
    }

    public function update(Request $request, Issue $issue)
    {
        $issueData = $request->validate([
            'title' => 'required|max:60',
            'body'  => 'required|max:255',
        ]);

        $issue->title = $issueData['title'];
        $issue->body = $issueData['body'];
        $issue->save();

        flash(__('issue.updated'), 'success');

        return redirect()->route('issues.show', $issue);
    }

    public function destroy(Request $request, Issue $issue)
    {
        $request->validate(['issue_id' => 'required']);

        if ($request->get('issue_id') == $issue->id && $issue->delete()) {
            flash(__('issue.deleted'), 'warning');

            return redirect()->route('issues.index');
        }

        flash(__('issue.undeleted'), 'danger');

        return back();
    }
}
