<?php

namespace App\Http\Controllers\ProjectManagement;

use App\Models\ProjectManagement\Projects\Comment;
use App\Models\ProjectManagement\Projects\ProjectJob;
use App\Models\ProjectManagement\Projects\JobsRepository;
use App\Models\ProjectManagement\Projects\Project;
use App\Models\CRM\Person\Person;
use App\Models\Core\Auth\User;
use App\Http\Controllers\Core\UserConverter;
use App\Http\Requests\ProjectManagement\Jobs\UpdateRequest;
use App\Http\Requests\ProjectManagement\Jobs\DeleteRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * Jobs Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class JobsController extends Controller
{
    /**
     * @var \App\Models\ProjectManagement\Projects\JobsRepository
     */
    private $repo;

    /**
     * Create new Jobs Controller.
     *
     * @param  \App\Models\ProjectManagement\Projects\JobsRepository  $repo
     */
    public function __construct(JobsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Show unfinished job list.
     *
     * @return \Illuminate\View\View
     */
    public function index( Request $request)
    {
        $user = auth()->user();

        if (!$user->hasRole('admin')) {
            $projects = Project::whereIn('status_id', [2, 3])->pluck('name', 'id');
        } else {
            $projects = $user->projects()
                ->whereIn('status_id', [2, 3])
                ->pluck('projects.name', 'projects.id');
        }

        // Extract the IDs from the collection
        $ids = $projects->keys();

        // Fetch data related to the IDs
        $jobs = ProjectJob::whereIn('project_id', $ids)->get();

        return view('crm.jobs.unfinished', compact('jobs', 'projects'));
    }

    /**
     * Show a job detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectManagement\Projects\Job  $job
     * @return \Illuminate\View\View
     */
    public function show(Request $request, ProjectJob $job)
    {



        $this->authorize('view', $job);

        $editableTask = null;
        $editableComment = null;
        $comments = $job->comments()->with('creator')->latest()->paginate();

        if ($request->get('action') == 'task_edit' && $request->has('task_id')) {
            $editableTask = $this->repo->requireTaskById($request->get('task_id'));
        }

        if ($request->get('action') == 'task_delete' && $request->has('task_id')) {
            $editableTask = $this->repo->requireTaskById($request->get('task_id'));
        }

        if (request('action') == 'comment-edit' && request('comment_id') != null) {
            $editableComment = Comment::find(request('comment_id'));
        }
        $project = $job->project; // Assuming a Job belongs to a Project


         $persons = Person::pluck('name', 'id');

    return view('crm.jobs.show', compact('job', 'editableTask', 'comments', 'editableComment', 'persons','project'));
}

    /**
     * Show a job edit form.
     *
     * @param  \App\Models\ProjectManagement\Projects\Job  $job
     * @return \Illuminate\View\View
     */
    public function edit(ProjectJob $job)
    {
        $this->authorize('view', $job);

        $persons = $this->repo->getPersonsList();

        return view('crm.jobs.edit', compact('job', 'persons'));
    }

    /**
     * Update a job on database.
     *
     * @param  \App\Http\Requests\Jobs\UpdateRequest  $request
     * @param  \App\Models\ProjectManagement\Projects\Job  $job
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request, ProjectJob $job)
    {
        $job = $this->repo->update($request->except(['_method', '_token']), $job->id);
        flash(__('job.updated'), 'success');

        return redirect()->route('jobs.show', $job);
    }

    /**
     * Show job delete confirmation page.
     *
     * @param  \App\Models\ProjectManagement\Projects\ProjectJob  $job
     * @return \Illuminate\View\View
     */
    public function delete(ProjectJob $job)
    {
        return view('crm.jobs.delete', compact('job'));
    }

    /**
     * Show job delete confirmation page.
     *
     * @param  \App\Http\Requests\Jobs\DeleteRequest  $request
     * @param  \App\Models\ProjectManagement\Projects\ProjectJob  $job
     * @return \Illuminate\View\View
     */
    public function destroy(DeleteRequest $request, ProjectJob $job)
    {
        $projectId = $job->project_id;

        if ($job->id == $request->get('project_job_id')) {
            $job->tasks()->delete();
            $job->delete();
            flash(__('job.deleted'), 'success');
        } else {
            flash(__('job.undeleted'), 'danger');
        }

        return redirect()->route('projects.jobs.index', $projectId);
    }

    /**
     * Reorder job task position.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectManagement\Projects\ProjectJob  $job
     * @return string|null
     */
    public function tasksReorder(Request $request, ProjectJob $job)
    {
        if ($request->expectsJson()) {
            $data = $this->repo->tasksReorder($request->get('postData'));

            return 'oke';
        }
    }
}
