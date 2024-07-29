<?php

namespace App\Http\Requests\CRM\Objectives;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Validation\Validator;

class KeyResultRequest extends FormRequest
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
            'krs_title' => 'required',
            'krs_conf' => 'required|numeric|min:0|max:10',
            'krs_init' => 'required',
            'krs_tar' => 'required|different:krs_init',
            'krs_now' => 'required',
            'krs_weight' => 'required|numeric|min:0.1|max:2',
        ];
    }

    public function attributes()
    {
        return [
            'krs_title' => 'Key Result Title',
            'krs_conf' => 'Confidence Level',
            'krs_init' => 'Initial Value',
            'krs_tar' => 'Target Value',
            'krs_now' => 'Current Value',
            'krs_weight' => 'Weight',
        ];
    }
    
    public function messages()
    {
        return [
            'krs_title.required' => 'Cannot be blank!',
            'krs_conf.required' => 'Cannot be blank!',
            'krs_init.required' => 'Cannot be blank!',
            'krs_tar.required' => 'Cannot be blank!',
            'krs_now.required' => 'Cannot be blank!',
            'krs_weight.required' => 'Cannot be blank!',
            'krs_tar.different' => 'Must be different from the initial value',
            'krs_conf.min' => 'Must be greater than 0',
            'krs_conf.max' => 'Must be less than 10',
            'krs_weight.min' => 'Must be greater than 0.1',
            'krs_weight.max' => 'Must be less than 2',
        ];
    }
    
    /**
     *  辨識Kr持有者。
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (count($validator->errors())) {
                $validator->errors()->add('krs_owner', $this->validationData()['krs_owner']);
            }
        });
    }
}
