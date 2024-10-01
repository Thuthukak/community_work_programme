<?php

namespace App\Models\CRM\Opportunity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\CRM\Organization\Organization;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CRM\JobPost\JobPost;
use App\Models\Core\Auth\User;
use App\Models\CRM\Opportunity\Opportunity;
use App\Models\CRM\Company\Company;




class Opportunity extends Model
{
    use SoftDeletes;

    use HasFactory;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $guarded  = [];


    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function jobpost()
    {
        return $this->hasMany(JobPost::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function checkApplication(){
        return DB::table('opportunity_user')->where('opportunity_id', auth()->user()->id)->where('opportunity_id', $this->id)->exists();
    }

    public function favorites(){
        return $this->belongsToMany(Opportunity::class, 'favorites', 'job_id', 'user_id')->withTimestamps();
    }

    public function checkSaved(){
        return DB::table('favorites')->where('user_id', auth()->user()->id)->where('job_id', $this->id)->exists();
    }
}
