<?php

namespace App\Events\Jobs;

use App\Models\ProjectManagement\Projects\Job;

class Created
{
    public $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }
}
