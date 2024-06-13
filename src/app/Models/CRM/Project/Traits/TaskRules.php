<?php

namespace App\Models\CRM\Project\Traits;

trait ProjectRules
{
    public function createdRules(): array
    {
        return [
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
            'progress'    => 'required|numeric|max:100',
        ];
    }

    public function updatedRules(): array
    {
        return [
            'name'        => 'required|max:60',
            'description' => 'nullable|max:255',
            'progress'    => 'required|numeric|max:100',
            'job_id'      => 'required|numeric|exists:jobs,id',
        ];
    }


    public function deleteRules(): array
    {
        return [
            'task_id' => 'required',
            'job_id'  => 'required',
        ];
    }
}
