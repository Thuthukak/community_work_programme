<?php

namespace App\Http\Controllers\ProjectManagement\Issues;

use App\Models\ProjectManagement\Projects\Comment;
use App\Models\ProjectManagement\Projects\Issue;
use App\Models\ProjectManagement\Projects\File;
use App\Models\ProjectManagement\Projects\IssueStatus;
use App\Models\ProjectManagement\Projects\Priority;
use App\Models\ProjectManagement\Projects\Project;
use App\Models\CRM\Person\Person;
use App\Models\Core\Auth\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IssueController extends Controller
{


    public function index(Request $request)
    {

        // dd($request);

        // $status = null;
        // $statusId = $request->get('status_id');
        // if ($statusId) {
        //     $status = $this->repo->getIssueStatusName($statusId);
        // }

        // $issues = $this->repo->getIssues($request->get('q'), $statusId, $user);


        $issues = Issue::with('project', 'creator', 'pic') 
        ->get();
        // dd($issues);

        foreach($issues as $issue)
        {
            $issue->project_url = route('projects.show' , $issue->project_id);
        }
        

        return view('crm.issues.index', compact('issues'));
    }


    public function showIssue(Issue $issue)
    {

        $editableComment = null;
        $priorities = Priority::toArray();
        $statuses = IssueStatus::toArray();
        $users = User::pluck('first_name', 'id');
        $comments = $issue->comments()->with('creator')->get();


        if (empty($project->items)) {
            $project = Project::find($issue->project_id);
            $tableName = $project->getTable();
            $projectId = $project->id;
            $files = File::where('fileable_type', $tableName)
                        ->where('fileable_id', $projectId)
                        ->get();
        }

        if (request('action') == 'comment-edit' && request('comment_id') != null) {
            $editableComment = Comment::find(request('comment_id'));
        }

        $projects = Project::pluck('name', 'id');


        return view('crm.issues.show', compact(
            'project','projects', 'issue', 'users', 'statuses', 'priorities', 'comments',
            'editableComment','files'
        ));
        }

    public function show(Project $project, Issue $issue)
    {
        $editableComment = null;
        $priorities = Priority::toArray();
        $statuses = IssueStatus::toArray();
        $users = User::pluck('first_name', 'id');
        $comments = $issue->comments()->with('creator')->get();


        if (empty($project->items)) {
            // Retrieve the project from the database
            $project = Project::find($project->id);
        
            // Retrieve the table name and id
            $tableName = $project->getTable();
            // dd($tableName);

            $projectId = $project->id;
            // dd($projectId);

        
            // Retrieve the associated files
            $files = File::where('fileable_type', $tableName)
                         ->where('fileable_id', $projectId)
                         ->get();

                                //  dd(DB::getQueryLog()); // Show results of log
        }
     

        if (request('action') == 'comment-edit' && request('comment_id') != null) {
            $editableComment = Comment::find(request('comment_id'));
        }

        return view('crm.projects.issues.show', compact(
            'project','issue', 'users', 'statuses', 'priorities', 'comments',
            'editableComment','files'
        ));
    }


    public function store(Request $request)
    {
        // Validate the incoming request data
        $issueData = $request->validate([
            'title'       => 'required|max:60',
            'body'        => 'required|max:255',
            'priority_id' => 'required|in:1,2,3',
            'pic_id'      => 'nullable|exists:users,id',
            'project_id'  => 'required|exists:projects,id',
        ]);
    
        // Create a new issue and store it in the $issue variable
        $issue = Issue::create([
            'project_id'  => $issueData['project_id'],
            'creator_id'  => auth()->id(),
            'title'       => $issueData['title'],
            'body'        => $issueData['body'],
            'priority_id' => $issueData['priority_id'],
            'pic_id'      => $issueData['pic_id'],
        ]);
    
        // Display a success message
        flash(__('issue.created'), 'success');
    
        // Redirect to the show page for the newly created issue
        return redirect()->route('issues.show', $issue->id);
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

        return redirect()->route('issues.show', [ $issue->id]);
    }

}
