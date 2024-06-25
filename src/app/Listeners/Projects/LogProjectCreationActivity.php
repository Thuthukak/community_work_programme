<?php

namespace App\Listeners\Projects;

use App\Models\ProjectManagement\Users\Activity;
use App\Models\CRM\Person\Person;
use App\Events\Projects\Created;

class LogProjectCreationActivity
{
    public function handle(Created $event)
    {
        $project = $event->project;

        $activityEntry = [
            'type'        => 'project_created',
            'parent_id'   => null,
            'user_id'     => auth()->id(),
            'object_id'   => $project->id,
            'object_type' => 'projects',
        ];

        Activity::create($activityEntry);
    }
}
