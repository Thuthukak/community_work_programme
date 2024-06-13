<?php

namespace App\Models\CRM\Project\Traits;

trait ProjectRules
{
    public function createdRules(): array
    {
        return [
            'name'              => 'required|max:60',
            'price'             => 'required|numeric',
            'worker_id'         => 'required|numeric',
            'type_id'           => 'required|numeric',
            'target_start_date' => 'nullable|date|date_format:Y-m-d',
            'target_end_date'   => 'nullable|date|date_format:Y-m-d',
            'description'       => 'max:255',
        ];
    }

    public function updatedRules(): array
    {
        return [
            'name'        => 'required|max:60',
            'price'       => 'required|numeric',
            'worker_id'   => 'required|numeric',
            'type_id'     => 'required|numeric',
            'description' => 'max:255',
        ];
    }
    public function deleteRules(): array
    {
        return [
            'job_id'     => 'required',
            'project_id' => 'required',
        ];
    }
}
