<?php

namespace App\Models\CRM\Project\Traits;

trait ProjectRules
{
    public function createdRules(): array
    {
        return [
            'name'           => 'required|max:50',
            'proposal_date'  => 'nullable|date|date_format:Y-m-d',
            'proposal_value' => 'nullable|numeric',
            'customer_id'    => 'nullable|numeric',
            'customer_name'  => 'nullable|required_without:customer_id|max:60',
            'customer_email' => 'nullable|required_without:customer_id|email|unique:users,email',
            'description'    => 'nullable|max:255',
        ];
    }

    public function updatedRules(): array
    {
        return [
            'name'           => 'required|max:50',
            'description'    => 'nullable|max:255',
            'proposal_date'  => 'nullable|date|date_format:Y-m-d',
            'proposal_value' => 'nullable|numeric',
            'start_date'     => 'nullable|date|date_format:Y-m-d',
            'end_date'       => 'nullable|date|date_format:Y-m-d',
            'due_date'       => 'nullable|date|date_format:Y-m-d',
            'project_value'  => 'nullable|numeric',
            'customer_id'    => 'nullable|numeric',
            'status_id'      => 'required|numeric',
        ];
    }
}
