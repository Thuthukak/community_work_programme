<?php

namespace App\Events\Projects;

use App\Models\ProjectManagement\Projects\Project;

class Updated
{
    public $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}
