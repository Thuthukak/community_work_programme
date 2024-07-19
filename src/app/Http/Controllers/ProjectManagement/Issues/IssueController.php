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
        

        return view('crm.issues.index', compact('issues'));
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
            'project', 'issue', 'users', 'statuses', 'priorities', 'comments',
            'editableComment','files'
        ));
    }
}
