<?php

namespace App\Http\Requests\CRM\Objectives;

use Illuminate\Foundation\Http\FormRequest;

class ActionRequest extends FormRequest
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
            'act_title' => 'required',
            'st_date' => 'required|date',
            'fin_date' => 'required|date|after:st_date',
            'act_content' => 'required',
            'model_id' =>'required',
            'model_type' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'act_title' => 'Action Title',
            'st_date' => 'Start Date',
            'fin_date' => 'Finish Date',
            'act_content' => 'Content',
            'model_id'  => 'Action To'
        ];
    }
    


}
