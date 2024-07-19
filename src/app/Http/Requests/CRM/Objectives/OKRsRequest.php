<?php

namespace App\Http\Requests\CRM\Objectives;

use Illuminate\Foundation\Http\FormRequest;

class OKRsRequest extends FormRequest
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
            'st_date' => 'required',
            'fin_date' => 'required|different:st_date',
            'krs_title.*.id' => 'required',
            'krs_conf.*.id' => 'required',
            'krs_init.*id' => 'required',
            'krs_tar.*.id' => 'required|different:krs_init.*',
            'krs_now.*.id' => 'required',
            'krs_weight.*.id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'obj_title' => 'Objective',
            'st_date' => 'Start Date',
            'fin_date' => 'Finish Date',
            'krs_title.$keyresult->id' => 'Key Result',
            // Uncomment and translate other attributes as needed
            // 'krs_conf' => 'Confidence',
            // 'krs_init' => 'Initial Value',
            // 'krs_tar' => 'Target Value',
            // 'krs_now' => 'Current Value',
            // 'krs_weight' => 'Weight',
        ];
    }
    
    public function messages()
    {
        return [
            'obj_title.required' => ':attribute cannot be blank',
            'st_date.required' => ':attribute cannot be blank',
            'fin_date.required' => ':attribute cannot be blank',
            'krs_title.$keyresult->id.required' => ':attribute cannot be blank',
            // Uncomment and translate other messages as needed
            // 'krs_conf.required' => ':attribute cannot be blank',
            // 'krs_init.required' => ':attribute cannot be blank',
            // 'krs_tar.required' => ':attribute cannot be blank',
            // 'krs_now.required' => ':attribute cannot be blank',
            // 'krs_weight.required' => ':attribute cannot be blank',
        ];
    }
    

}
