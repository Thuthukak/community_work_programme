<?php

namespace App\Models\CRM\JobPost\Traits;

trait JobRules
{
    public function createdRules(): array
    {    
        return [
            'title'=> 'required|max:150',
            'position'=> 'required|max:255',
            'description'=> 'required|max:5000',
            'roles'=> 'required|max:800',
            'address'=> 'required|max:500',
            'experience'=> 'required|numeric',
            'gender'=> 'required',
            'salary'=> 'required',
            'number_of_vacancy'=> 'required|numeric',
            'type'=> 'required',
            'last_date'=> 'required',

           
        ];
    }

    public function updatedRules(): array
    {
      
        return [
            'title'=> 'required|max:150',
            'position'=> 'required|max:255',
            'description'=> 'required|max:5000',
            'roles'=> 'required|max:800',
            'address'=> 'required|max:500',
            'experience'=> 'required|numeric',
            'gender'=> 'required',
            'salary'=> 'required',
            'number_of_vacancy'=> 'required|numeric',
            'type'=> 'required',
            'last_date'=> 'required',

           
        ];
    }
}
