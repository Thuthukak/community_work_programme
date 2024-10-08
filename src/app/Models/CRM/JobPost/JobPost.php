<?php

namespace App\Models\CRM\JobPost;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CRM\OppCategory\OpportunityCategorie;
use App\Models\CRM\JobPost\Traits\JobRules;
use App\Models\CRM\Opportunity\Opportunity;



class JobPost extends Model
{
    use SoftDeletes,JobRules;

    use HasFactory;

    public function getRouteKeyName()
    {
        return 'slug';
    }


    protected $guarded  = [];

    public function category(){
        return $this->belongsTo(OpportunityCategorie::class);
    }

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }


}