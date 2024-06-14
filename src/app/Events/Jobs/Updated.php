<?php

namespace App\Events\Jobs;

use App\Models\ProjectManagement\Projects\ProjectJob;

class Updated
{
    public $job;

    public function __construct(ProjectJob $job)
    {
        $this->job = $job;
    }
}
