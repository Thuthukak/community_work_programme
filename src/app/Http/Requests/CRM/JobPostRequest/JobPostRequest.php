<?php

namespace App\Http\Requests\CRM\JobPostRequest;


use App\Http\Requests\BaseRequest;
use App\Models\CRM\JobPost\JobPost;
use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends BaseRequest
{

    public function rules()
    {
        return $this->initRules(new JobPost());
    }
}
