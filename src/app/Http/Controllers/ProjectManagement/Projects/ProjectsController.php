<?php

namespace App\Http\Controllers\ProjectManagement\Projects;

use App\Models\ProjectManagement\Projects\Project;
use App\Models\ProjectManagement\Projects\ProjectsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectManagement\Projects\CreateRequest;
use App\Http\Requests\ProjectManagement\Projects\UpdateRequest;
use App\Models\Core\Auth\User;
use Illuminate\Http\Request;

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

    public function __construct(ProjectsRepository $repo)
    {
        $this->repo = $repo;
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
        // dd($statusId);
        if ($statusId) {
            $status = $this->repo->getStatusName($statusId);
        }

       // Convert authenticated user to ProjectManagement\Users\User instance
       $user = auth()->user();

       $projects = $this->repo->getProjects($request->get('q'), $statusId, $user);


       $this->authorize('create', new Project());

       $Organization = $this->repo->getOrganizationsList();


       return view('crm.projects.index', compact('projects', 'status', 'statusId','Organization'));
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



    // private function convertToProjectManagementUser($user)
    // {
    //     // Assuming the User models are interchangeable and you can simply return it
    //     // If not, you might need to create a new instance and map properties accordingly
    //     return new User([
    //         'id' => $user->id,
    //         'name' => $user->first_name,
    //         'email' => $user->email,
    //         "password" => $user->password,
    //         "remember_token" => $user->remember_token,
    //         "lang" => $user->lang,
    //         "lang" => $user->lang,
    //         "created_at" => $user->created_at,
    //         "updated_at" => $user->updated_at
    //         // map other properties as needed
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
        // dd($project);
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

        return view('crm.projects.show', compact('project'));
    }

    /**
     * Show project edit page.
     *
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

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

        return redirect()->route('projects.edit', $project);
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
