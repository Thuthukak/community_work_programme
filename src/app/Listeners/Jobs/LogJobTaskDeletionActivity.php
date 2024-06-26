<?php

namespace App\Listeners\Jobs;

use App\Models\ProjectManagement\Users\Activity;
use App\Models\CRM\Person\Person;
use App\Events\Tasks\Deleted;

class LogJobTaskDeletionActivity
{
    public function handle(Deleted $event)
    {
        $task = $event->task;
        $jobId = $task->project_job_id;

        $activityEntry = [
            'type'        => 'task_deleted',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $jobId,
            'object_type' => 'jobs',
            'data'        => [
                'name'        => $task->name,
                'description' => $task->description,
                'progress'    => $task->progress,
            ],
        ];

        Activity::create($activityEntry);
    }
}
