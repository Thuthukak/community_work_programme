<?php

namespace App\Http\Requests\ProjectManagement\Jobs;

use App\Models\ProjectManagement\Projects\Project;
use App\Models\CRM\Person\Person;
use App\Http\Requests\Request;

class CreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project = Project::findOrFail($this->segment(2));

        return auth()->user()->can('manage_jobs', $project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|max:60',
            'price'             => 'required|numeric',
            'person_id'         => 'required|numeric',
            'type_id'           => 'required|numeric',
            'target_start_date' => 'nullable|date|date_format:Y-m-d',
            'target_end_date'   => 'nullable|date|date_format:Y-m-d',
            'description'       => 'max:255',
        ];
    }
}
