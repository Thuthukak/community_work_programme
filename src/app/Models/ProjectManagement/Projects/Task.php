<?php

namespace App\Models\ProjectManagement\Projects;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => 'App\Events\Tasks\Created',
        'updated' => 'App\Events\Tasks\Updated',
        'deleted' => 'App\Events\Tasks\Deleted',
    ];


    protected $fillable = [
        'name',
        'description',
        'project_job_id', 
        'progress',
        'position'
       ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $touches = ['job'];

    public function job()
    {
        return $this->belongsTo(ProjectJob::class, 'project_job_id');
    }
}
