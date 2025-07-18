<?php

namespace App\Http\Requests\ProjectManagement\Projects;

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
        return auth()->user()->can('create', new Project());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => 'required|max:50',
            'proposal_date'  => 'nullable|date|date_format:Y-m-d',
            'proposal_value' => 'nullable|numeric',
            'organization_id'    => 'nullable|numeric',
            'organization_name'  => 'nullable|required_without:organization_id|max:60',
            'organization_email' => 'nullable|required_without:organization_id|email|unique:users,email',
            'description'    => 'nullable|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'organization_name.required_without'  => __('validation.project.customer_name.required_without'),
            'organization_email.required_without' => __('validation.project.customer_email.required_without'),
        ];
    }
}
