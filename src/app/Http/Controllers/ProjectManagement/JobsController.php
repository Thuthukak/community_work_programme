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
use App\Filters\CRM\TasksFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


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
    public function __construct(JobsRepository $repo ,TasksFilter $Filter)
    {
        $this->repo = $repo;
        $this->filter = $Filter;
    }

    /**
     * Show unfinished job list.
     *
     * @return \Illuminate\View\View
     */
    public function index( Request $request)
    {
        $user = auth()->user();
        // dd($request);

        // if (!$user->hasRole('admin')) {
        //     $projects = Project::whereIn('status_id', [2, 3])->pluck('name', 'id');
        // } else {
        //     $projects = $user->projects()
        //         ->whereIn('status_id', [2, 3])
        //         ->pluck('projects.name', 'projects.id');
        // }

        // // Extract the IDs from the collection
        // $ids = $projects->keys();

        $status = null;
        $statusId = $request->get('status_id');
        if ($statusId) {

            $status = $this->repo->getStatusName($statusId);
        }
       // Convert authenticated user to ProjectManagement\Users\User instance
       $user = auth()->user();

       $projects = $this->repo->getProjects($request->get('q'), $statusId, $user);

        // Fetch data related to the IDs
        $ids = $projects->getCollection()->map(function($project) {
            return $project->id;
        })->toArray();

        $jobs = ProjectJob::whereIn('project_id', $ids)->get();
        // dd($jobs);

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
     * get tasks by filters
    * @param  \App\Models\ProjectManagement\Projects\Job  $job
     * @return \Illuminate\View\View
     */

     public function getTasksByFilter(Request $request )
     {

        $classes = json_decode($request->get('classes'), true);

        // dd($classes);
        $user = auth()->user();

        $query = ProjectJob::query();
        $projects = $this->repo->getProjectById($request->get('projects'));
        $this->filter->apply($query);


        if($request->has('projects'))
        {

            $this->filter->tasks($request->get('projects'));
        }
        if($request->has('Organization')){
            $this->filter->organization($request->get('organization'));
        }
        if($request->has('classes')){
            $this->filter->classes($classes);
        }


        $jobs = $query->with('tasks')->paginate(10); // Ensure subtasks are eager loaded

        $totalTasksCount = 0;
        $totalProgress = 0;
        $totalPrice = 0;
        $jobCount = $jobs->count();
    
        // dd($jobs);
        foreach ($jobs as $job) {
            // dd($job->progress);
            // Calculate total tasks count
            $job->tasks_count = $job->tasks->count();
            $job->show_url =  route('jobs.show', $job->id);
            $job->project_Show_Link = route('projects.show', $job->project_id);
            $job->created_at = Carbon::parse($job->created_at);
            $job->created_at = date_format($job->created_at, "Y-m-d"); 
            $job->tasks_count = $job->tasks->count();
            $totalTasksCount += $job->tasks_count;
            $job->progress = format_decimal($job->progress);
            // $job->price = format_money($job->price);
            $job->show = route('jobs.show', $job->id);
            $job->person_name = $job->person->name;
            $job->project_name = $job->project->name;
    
            // Sum the progress
            $totalProgress += $job->progress;
    
            // Handle the formatted price if the user has permission
            if (auth()->user()->can('see-pricings', $job)) {
                $job->formatted_price = format_money($job->price);
                $totalPrice += $job->price;
            } else {
                $job->formatted_price = null;
            }
        }
        // dd($jobs);
    
        // Calculate average progress
        $avgProgress = $jobCount > 0 ? $totalProgress / $jobCount : 0;
    
        // Format the total price and average progress for the view
        $formattedTotalPrice = format_money($totalPrice);
        $formattedAvgProgress = number_format($avgProgress, 2) . ' %';

        $this->authorize('create', new ProjectJob());
        // Return the projects and organization list as JSON if the request is AJAX
        return response()->json([
            'projects' => $projects,
            'jobs' => $jobs,
            'totalTasksCount' => $totalTasksCount, 
            'formattedAvgProgress' => $formattedAvgProgress , 
            'formattedTotalPrice' => $formattedTotalPrice,
        ]);

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
