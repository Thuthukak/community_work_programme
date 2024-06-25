<?php

namespace App\Http\Controllers\ProjectManagement\Projects;

use App\Models\ProjectManagement\Projects\ProjectJob;
use App\Models\ProjectManagement\Projects\Task;
use App\Http\Controllers\Controller;
use App\Models\CRM\Person\Person;
use App\Http\Requests\ProjectManagement\Tasks\CreateRequest;
use App\Http\Requests\ProjectManagement\Tasks\DeleteRequest;
use App\Http\Requests\ProjectManagement\Tasks\UpdateRequest;
use DB;

/**
 * Project Tasks Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class TasksController extends Controller
{
    /**
     * Store a created ProjectJob task to the database.
     *
     * @param  \App\Http\Requests\ProjectManagement\Tasks\CreateRequest  $request
     * @param  \App\Models\ProjectManagement\Projects\ProjectJob  $job
     * @return \Illuminate\Routing\Redirector
     */
    public function store(CreateRequest $request, ProjectJob $job)
    {
        $newTask = $request->validated();
        $newTask['project_job_id'] = $job->id;
        $task = Task::create($newTask);

        flash(__('task.created'), 'success');

        return redirect()->route('jobs.show', $job);
    }

    /**
     * Update a task on the database.
     *
     * @param  \App\Http\Requests\ProjectManagement\Tasks\UpdateRequest  $request
     * @param  \App\Models\ProjectManagement\Projects\Task  $task
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request, Task $task)
    {
        $task->update($request->validated());

        flash(__('task.updated'), 'success');

        return redirect()->route('jobs.show', $task->project_job_id);
    }

    /**
     * Delete task from the database.
     *
     * @param  \App\Http\Requests\ProjectManagement\Tasks\DeleteRequest  $request
     * @param  \App\Models\ProjectManagement\Projects\Task  $task
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(DeleteRequest $request, Task $task)
    {
        if ($task->id == $request->get('task_id')) {
            $task->delete();
            flash(__('task.deleted'), 'success');
        } else {
            flash(__('task.undeleted'), 'danger');
        }

        return redirect()->route('jobs.show', $task->project_job_id);
    }

    /**
     * Set a task to become a job.
     *
     * @param  \App\Models\ProjectManagement\Projects\Task  $task
     * @return \Illuminate\Routing\Redirector
     */
    public function setAsJob(Task $task)
    {
        $oldJob = $task->job;

        $job = new ProjectJob;
        $job->name = $task->name;
        $job->description = $task->description;
        $job->project_id = $oldJob->project_id;
        $job->person_id = $oldJob->person_id;

        DB::beginTransaction();
        $job->save();
        $task->delete();
        DB::commit();

        flash(__('task.upgraded_as_job'), 'success');

        return redirect()->route('jobs.edit', $job);
    }

    public function setDone(Task $task)
    {
        $task->progress = 100;
        $task->save();

        flash(__('task.updated'), 'success');

        return redirect()->route('jobs.show', $task->job);
    }
}
