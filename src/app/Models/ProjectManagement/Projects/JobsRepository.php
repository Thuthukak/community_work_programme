<?php

namespace App\Models\ProjectManagement\Projects;

use App\Models\ProjectManagement\BaseRepository;
use App\Models\Core\Auth\User;
use App\Models\CRM\Person\Person;
use App\Models\ProjectManagement\Projects\Project;
use App\Http\Controllers\Core\UserConverter;
use App\Queries\AdminDashboardQuery;
use ProjectStatus;
use DB;

/**
 * Jobs Repository.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class JobsRepository extends BaseRepository
{
    protected $model;

    public function __construct(ProjectJob $model)
    {
        parent::__construct($model);
    }

    public function getUnfinishedJobs(User $user, $projectId = null)
    {
        
        return (new AdminDashboardQuery())
            ->onProgressJobs($user, ['project', 'organization'], $projectId);
    }



    private function convertToProjectManagementUser($user)
    {
        // Assuming the User models are interchangeable and you can simply return it
        // If not, you might need to create a new instance and map properties accordingly
        return new User([
            'id' => $user->id,
            'name' => $user->first_name,
            'email' => $user->email,
            "password" => $user->password,
            "remember_token" => $user->remember_token,
            "lang" => $user->lang,
            "lang" => $user->lang,
            "created_at" => $user->created_at,
            "updated_at" => $user->updated_at
            // map other properties as needed
        ]);
    }

    
    public function requireProjectById($projectId)
    {
        return Project::findOrFail($projectId);
    }

    public function createJob($jobData, $projectId)
    {

        // dd($jobData);
        $jobData['project_id'] = $projectId;

        return $this->storeArray($jobData);
    }

    public function createJobs($jobsData, $projectId)
    {
        $selectedJobs = $this->model->whereIn('id', $jobsData['project_job_ids'])->get();

        DB::beginTransaction();
        foreach ($selectedJobs as $job) {
            $newJob = $job->replicate();
            $newJob->project_id = $projectId;
            $newJob->save();

            if (isset($jobsData[$job->id.'_task_ids'])) {
                $selectedTasks = $job->tasks()->whereIn('id', $jobsData[$job->id.'_task_ids'])->get();

                foreach ($selectedTasks as $task) {
                    $newTask = $task->replicate();
                    $newTask->progress = 0;
                    $newTask->project_job_id = $newJob->id;
                    $newTask->save();
                }
            }
        }
        DB::commit();

        return 'ok';
    }

    public function getTasksByJobId($jobId)
    {
        return Task::whereJobId($jobId)->get();
    }

    public function requireTaskById($taskId)
    {
        return Task::findOrFail($taskId);
    }

    public function update($jobData, $jobId)
    {
        foreach ($jobData as $key => $value) {
            if (!$jobData[$key]) {
                $jobData[$key] = null;
            }
        }

        $jobData['price'] = str_replace('.', '', $jobData['price']);
        $job = $this->requireById($jobId);
        $job->update($jobData);

        return $job;
    }


    public function getStatusName($statusId)
    {


        return ProjectStatus::getNameById($statusId);
    }
    public function getProjects($q, $statusId, User $user)
    {


        $statusIds = array_keys(ProjectStatus::toArray());


        // dd($user->hasRole('admin'));



        if ($user->hasRole('admin') == true) {

        // if (true) {


                return $user->projects()
                ->where(function ($query) use ($q, $statusId, $statusIds) {
                    $query->where('projects.name', 'like', '%'.$q.'%');

                    if ($statusId && in_array($statusId, $statusIds)) {
                        $query->where('status_id', $statusId);
                    }
                })
                ->latest()
                ->with(['Organization', 'jobs'])
                ->paginate($this->_paginate);
        }

        return Project::where(function ($query) use ($q, $statusId, $statusIds) {
                if (!empty($q)) {
                    $query->where('projects.name', 'like', '%'.$q.'%');
                }
                
                if ($statusId && in_array($statusId, $statusIds)) {
                    $query->where('projects.status_id', $statusId);
                }
            })
            ->with('organization')
            ->paginate($this->_paginate);
        ;
    
    }

    public function tasksReorder($sortedData)
    {
        $taskOrder = explode(',', $sortedData);

        foreach ($taskOrder as $order => $taskId) {
            $task = $this->requireTaskById($taskId);
            $task->position = $order + 1;
            $task->save();
        }

        return $taskOrder;
    }


    public function getProjectById($ids = null)
    {
        // Convert the comma-separated string of IDs into an array
        $idArray = array_map('trim', explode(',', $ids));
    
        // Fetch projects by IDs
        return Project::whereIn('id', $idArray)
            ->with('organization')
            ->get();
    }
    
}
