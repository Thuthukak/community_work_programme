<?php

namespace App\Http\Requests\CRM\Projects;

use App\Http\Requests\BaseRequest;
use App\Models\ProjectManagement\Projects\Project;

class TaskRequest extends BaseRequest
{
    protected $phone;

    public function rules()
    {
        return $this->initRules(new Project());
    }

    // public function messages()
    // {
    //     return [
    //         'contact_type_id.required' => 'The project field is required.'
    //     ];
    // }
}
