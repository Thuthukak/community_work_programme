<?php

namespace App\Models\CRM\JobCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{   
     use HasFactory;

    protected $guarded  = [];


    public function jobs(){
    	return $this->hasMany(Job::class);
    }
    public function posts(){
    	return $this->hasMany(Post::class);
    }
}
