<?php

namespace App\Http\Controllers\ProjectManagement\Projects;

use App\Models\ProjectManagement\Projects\Project;
use App\Models\ProjectManagement\Projects\File;
use App\Models\ProjectManagement\Projects\ProjectsRepository;
use App\Http\Controllers\Controller;
use App\Models\CRM\Person\Person;
use App\Models\CRM\Organization\Organization;
use App\Http\Requests\ProjectManagement\Projects\CreateRequest;
use App\Http\Requests\ProjectManagement\Projects\UpdateRequest;
use App\Models\Core\Auth\User;
use App\Filters\CRM\ProjectsFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

/**
 * Projects Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class ProjectsController extends Controller
{
    /**
     * Projects Repository class.
     *
     * @var \App\Models\ProjectManagement\Projects\ProjectsRepository
     */
    private $repo;

    public function __construct(ProjectsRepository $repo , ProjectsFilter $Filter)
    {
        $this->repo = $repo;
        $this->filter = $Filter;
    }

    /**
     * List of projects.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $status = null;
        $statusId = $request->get('status_id');
        if ($statusId) {
            $status = $this->repo->getStatusName($statusId);
        }

       $user = auth()->user();

       $projects = $this->repo->getProjects($request->get('q'), $statusId, $user);
    //    dd($projects);
       $this->authorize('create', new Project());

       $Organization = $this->repo->getOrganizationsList();


            if (request()->ajax()) {
                return response()->json([
                    'status' => $status,
                    'statusId' => $statusId,
                    'projects' => $projects,
                    'Organization' => $Organization
                ]);    
            }  
       return view('crm.projects.index', compact('projects', 'status', 'statusId','Organization'));
    }

    public function getProjects()
    {
        return response()->json(Project::all() );
    }

    public function getProjectByFilter(Request $request, ProjectsFilter $filter)
    {
        $statusId = null;
        $user = auth()->user();

        // dd($request);
        Log::info('Received Organization IDs:', ['ids' => $request]);

        // Start building the query for projects
        $query = Project::query();
        // Apply the query builder to the filter
        $this->filter->apply($query);
        // Apply the organization filter if IDs are provided
        if ($request->has('Organization')) {

            $this->filter->organization($request->get('Organization'));  // Apply the filter

        }elseif($request->has('minValue') || $request->has('maxValue')) {

            $this->filter->projectValue($request->get('minValue'), $request->get('maxValue'));  // Apply the filter

        }elseif($request->has('classes')) {

            $this->filter->classes($request->get('clauses'));  // Apply the filter

        }elseif ($request->has('startDate') || $request->has('endDate')) {
            $this->filter->createdAt($request->get('startDate'), $request->get('endDate'));  // Apply the filter
        }
        // Paginate the results
        $projects = $query->paginate(10);
        $Organization = $this->repo->getOrganizationsList();

        foreach ($projects as $project) {
            $project->organization = route('organizations.edit', $project->organization_id);
            $project->show_url = route('projects.show', $project->id);
            $project->status_text = $project->present()->status;
            $project->progress =format_decimal($project->getJobOveralProgress());
            $project->show_text = trans('app.show');
            $project->edit_text = trans('app.edit');

            if (isset($Organization[$project->organization_id])) {
                $project->OrganizationName = $Organization[$project->organization_id];
            }
            
            $project->work_duration = $project->work_duration ?? 'N/A';
            $project->overall_progress = $project->overall_progress ?? '0.00 %';
            $project->due_date = $project->due_date ?? 'N/A';
            $project->project_value = $project->project_value ?? 'N/A';
            $project->status_text = $project->present()->status ?? 'Unknown';

            if (auth()->user()->can('see-pricings', $project)) {
                $project->formatted_value = format_money($project->project_value);
            } else {
                $project->formatted_value = null; // or some default value if unauthorized
            }
        }
        $this->authorize('create', new Project());
        // Return the projects and organization list as JSON if the request is AJAX
        return response()->json([
            'status' => 'success',
            'statusId' => $statusId,
            'projects' => $projects,
            'Organization' => $Organization
        ]);
    }

    
    
    public function filter(Request $request)
    {
        $organizations = $request->input('organizations', []);

        $projects = Project::whereIn('organization_id', $organizations)->get();

        return response()->json([
            'projects' => $projects->map(function($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'start_date' => $project->start_date,
                    'work_duration' => $project->work_duration,
                    'progress' => $project->getJobOveralProgress(),
                    'due_date' => $project->due_date,
                    'project_value' => $project->project_value,
                    'status' => $project->present()->status,
                    'organization_id' => $project->organization_id,
                    'organization_name' => is_object($project->organization) ? $project->organization->name : $project->organization
                ];
            })
        ]);
    }


        /**
     * List of projects.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function index(Request $request)
    // {
    //     $status = null;
    //     $statusId = $request->get('status_id');
    //     if ($statusId) {
    //         $status = $this->repo->getStatusName($statusId);
    //     }

    //     // Convert authenticated user to ProjectManagement\Users\User instance
    //     $user = auth()->user();

    //     $projects = $this->repo->getProjects($request->get('q'), $statusId, $user);

    //     return response()->json([
    //         'projects' => $projects,
    //         'status' => $status,
    //         'statusId' => $statusId,
    //     ]);
    // }




    /**
     * Show create project form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', new Project());

        $Organization = $this->repo->getOrganizationsList();

        return view('crm.projects.create', compact('Organization'));
    }

    /**
     * Create new project.
     *
     * @param  \App\Http\Requests\Projects\CreateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {

        $this->authorize('create', new Project());

        $project = $this->repo->create($request->except('_token'));
        flash(__('project.created'), 'success');

        return redirect()->route('projects.show', $project);
    }

    /**
     * Show project detail page.
     *
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Project $project)
    {

        $this->authorize('view', $project);



        DB::enableQueryLog(); // Enable query log

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



        $Organization = $this->repo->getOrganizationsById($project->organization_id);
        // dd($Organization);

        // dd($project->files);


        return view('crm.projects.show', compact('project', 'Organization','files'));
    }

    // /**
    //  * Show project edit page.
    //  *
    //  * @param  \App\Models\ProjectManagement\Projects\Project  $project
    //  * @return \Illuminate\Contracts\View\View
    //  */
    // public function edit(Project $project)
    // {
    //     $this->authorize('update', $project);

    //     $Organization = $this->repo->getOrganizationsList();

    //     return view('crm.projects.edit', compact('project', 'Organization'));
    // }


    /**
     * Show project edit page or return project data as JSON for AJAX requests.
     *
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View
     */
     public function edit(Project $project)
    {
        $this->authorize('update', $project);

        $organizationid  = $project->organization_id;

       
        $Organization = Organization::where('id', $organizationid)->get();

        // dd($Organization); 

        if (request()->ajax()) {
            // Include the organization's details in the response
            return response()->json([
                'project' => $project,
                'organization' => $Organization
            ]);
        }

        $Organization = $this->repo->getOrganizationsList();
        return view('crm.projects.edit', compact('project', 'Organization'));
    }


    /**
     * Update project data.
     *
     * @param  \App\Http\Requests\Projects\UpdateRequest  $request
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project = $this->repo->update($request->validated(), $project->id);
        flash(__('project.updated'), 'success');

        return redirect()->route('projects.show', $project);
    }

    /**
     * Show project deletion confirmation page.
     *
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return \Illuminate\Contracts\View\View
     */
    public function delete(Project $project)
    {
        $this->authorize('delete', $project);

        return view('crm.projects.delete', compact('project'));
    }

    /**
     * Delete project record from the system.
     *
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        if ($project->id == request('project_id')) {
            $this->repo->delete($project->id);
            flash(__('project.deleted'), 'success');
        } else {
            flash(__('project.undeleted'), 'danger');
        }

        return redirect()->route('projects.index');
    }

    /**
     * Project subscription list page.
     *
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return \Illuminate\Contracts\View\View
     */
    public function subscriptions(Project $project)
    {
        $this->authorize('view-subscriptions', $project);

        $activeSbscriptions = $project->subscriptions()->where('status_id', 1)->get();
        $inactiveSbscriptions = $project->subscriptions()->where('status_id', 0)->get();

        return view('crm.projects.subscriptions', compact('project', 'activeSbscriptions', 'inactiveSbscriptions'));
    }

    // /**
    //  * Project payment list page.
    //  *
    //  * @param  \App\Models\ProjectManagement\Projects\Project  $project
    //  * @return \Illuminate\Contracts\View\View
    //  */
    // public function payments(Project $project)
    // {
    //     $this->authorize('view-payments', $project);

    //     $project->load('payments.partner');

    //     return view('crm.projects.payments', compact('project'));
    // }

    /**
     * Update project status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function statusUpdate(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $project = $this->repo->updateStatus($request->get('status_id'), $project->id);
        flash(__('project.updated'), 'success');

        return redirect()->route('projects.show', $project);
    }

    /**
     * Project jobs reorder action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return string|null
     */
    public function jobsReorder(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        if ($request->expectsJson()) {
            $data = $this->repo->jobsReorder($request->get('postData'));

            return 'oke';
        }
    }
}
