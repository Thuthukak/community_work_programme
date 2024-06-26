<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProjectManagement\Projects\Project;

class ProjectJobsController extends Controller
{
    public function index(Project $project)
    {
        $jobs = $project->jobs()->with(['tasks', 'person'])->get();
        
        return response()->json(['jobs' => $jobs]);
    }
}
