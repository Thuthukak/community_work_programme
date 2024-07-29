<?php

namespace App\Http\Controllers\ProjectManagement\Projects;

use App\Models\ProjectManagement\Projects\JobsRepository;
use App\Models\ProjectManagement\Projects\Project;
use App\Models\ProjectManagement\Projects\File;
use App\Http\Controllers\ProjectManagement\Controller;
use App\Http\Requests\ProjectManagement\Jobs\CreateRequest;
use App\Models\CRM\Person\Person;
use Illuminate\Http\Request;

/**
 * Project Jobs Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class JobsController extends Controller
{
    private $repo;

    public function __construct(JobsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Project $project)
    {
        $jobs = $project->jobs()->with(['tasks', 'person'])->get();

        $person = $this->repo->getPersonsList();

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

        
            // dd($project);
        }


        return view('crm.projects.jobs.index', compact('project', 'jobs','person','files'));
    }

    public function create(Project $project)
    {


        $workers = $this->repo->getWorkersList();

        return view('crm.projects.jobs.create', compact('project', 'workers'));
    }

    public function addFromOtherProject(Request $request, Project $project)
    {
        $selectedProject = null;
        $persons = $this->repo->getPersonsList();
        $projects = $this->getProjectsList();

        if ($request->has('project_id')) {
            $selectedProject = Project::find($request->get('project_id'));
        }


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

        
            // dd($project);
        }



        return view('crm.projects.jobs.add-from-other-project', compact('project', 'persons', 'projects', 'selectedProject','files'));
    }

    public function store(CreateRequest $req, Project $project)
    {
        // dd($project->id);
    
        $job = $this->repo->createJob($req->except('_token'), $project->id);
    
        flash(__('job.created'), 'success');
    
        return redirect()->route('jobs.show', $job->id);
    }
    
    public function storeFromOtherProject(Request $request, $projectId)
    {

        $request->validate(['project_job_ids' => 'required|array']);

        $this->repo->createJobs($request->except('_token'), $projectId);

        flash(__('job.created_from_other_project'), 'success');


        

        return redirect()->route('projects.jobs.index', $projectId);
    }

    public function jobsExport(Project $project, $exportType = 'html')
    {
        $jobs = $project->getJobList(request('job_type', 1));

        return view('crm.projects.jobs.export-html', compact('project', 'jobs'));
    }

    public function jobProgressExport(Project $project, $exportType = 'html')
    {
        $jobs = $project->getJobList(request('job_type', 1));

        return view('crm.projects.jobs.progress-export-html', compact('project', 'jobs'));
    }
}
