<?php

namespace App\Models\CRM\OppCategorie;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\Opportunity\Opportunity;
use App\Models\CRM\JobPost\JobPost;


class OpportunityCategorie extends Model
{
    use HasFactory;

    protected $guarded  = [];


    public function Opportunity(){
    	return $this->hasMany(Opportunity::class);
    }
    public function JobPost(){
    	return $this->hasMany(JobPost::class);
    }
}
