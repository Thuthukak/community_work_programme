<?php

namespace App\Events\Tasks;

use App\Models\ProjectManagement\Projects\Task;

class Updated
{
    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }
}
