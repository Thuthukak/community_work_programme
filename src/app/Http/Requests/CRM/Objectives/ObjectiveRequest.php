<?php

namespace App\Http\Requests\CRM\Objectives;

use Illuminate\Foundation\Http\FormRequest;

class ObjectiveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'obj_title' => 'required',
            'st_date' => 'required|date',
            'fin_date' => 'required|date|after:st_date',
        ];
    }

    public function attributes()
    {
        return [
            'obj_title' => 'Objective',
            'st_date' => 'Start Date',
            'fin_date' => 'Finish Date',
        ];
    }
    
    public function messages()
    {
        return [
            'obj_title.required' => ':attribute cannot be blank',
            'st_date.required' => ':attribute cannot be blank',
            'fin_date.required' => ':attribute cannot be blank',
        ];
    }
    

}