<?php

namespace App\Http\Controllers\ProjectManagement\Projects;

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
    public function index(Project $project)
    {
        $issueQuery = $project->issues()
            ->orderBy('updated_at', 'desc')
            ->with(['pic', 'creator'])
            ->withCount(['comments']);

        if ($priorityId = request('priority_id')) {
            $issueQuery->where('priority_id', $priorityId);
        }

        if ($statusId = request('status_id')) {
            $issueQuery->where('status_id', $priorityId);
        }

        $issues = $issueQuery->get();

        return view('crm.projects.issues.index', compact('project', 'issues'));
    }

    public function create(Project $project)
    {
        $users = User::pluck('First_name', 'id');
        $priorities = Priority::toArray();

        return view('crm.projects.issues.create', compact('project', 'users', 'priorities'));
    }

    public function store(Request $request, Project $project)
    {
        $issueData = $request->validate([
            'title'       => 'required|max:60',
            'body'        => 'required|max:255',
            'priority_id' => 'required|in:1,2,3',
            'pic_id'      => 'nullable|exists:users,id',
        ]);
        Issue::create([
            'project_id'  => $project->id,
            'creator_id'  => auth()->id(),
            'title'       => $issueData['title'],
            'body'        => $issueData['body'],
            'priority_id' => $issueData['priority_id'],
            'pic_id'      => $issueData['pic_id'],
        ]);
        flash(__('issue.created'), 'success');

        return redirect()->route('projects.issues.index', $project);
    }

    public function show(Project $project, Issue $issue)
    {
        $editableComment = null;
        $priorities = Priority::toArray();
        $statuses = IssueStatus::toArray();
        $users = User::pluck('first_name', 'id');
        $comments = $issue->comments()->with('creator')->get();

        if (request('action') == 'comment-edit' && request('comment_id') != null) {
            $editableComment = Comment::find(request('comment_id'));
        }

        return view('crm.projects.issues.show', compact(
            'project', 'issue', 'users', 'statuses', 'priorities', 'comments',
            'editableComment'
        ));
    }

    public function edit(Project $project, Issue $issue)
    {
        return view('crm.projects.issues.edit', compact('project', 'issue'));
    }

    public function update(Request $request, Project $project, Issue $issue)
    {
        $issueData = $request->validate([
            'title' => 'required|max:60',
            'body'  => 'required|max:255',
        ]);
        $issue->title = $issueData['title'];
        $issue->body = $issueData['body'];
        $issue->save();

        flash(__('issue.updated'), 'success');

        return redirect()->route('projects.issues.show', [$project, $issue]);
    }

    public function destroy(Request $request, Project $project, Issue $issue)
    {
        $request->validate(['issue_id' => 'required']);

        if ($request->get('issue_id') == $issue->id && $issue->delete()) {
            flash(__('issue.deleted'), 'warning');

            return redirect()->route('projects.issues.index', $project);
        }
        flash(__('issue.undeleted'), 'danger');

        return back();
    }
}
