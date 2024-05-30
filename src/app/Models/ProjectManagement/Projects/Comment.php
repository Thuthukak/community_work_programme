<?php

namespace App\Models\ProjectManagement\Projects;

use App\Models\ProjectManagement\Users\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'creator_id'];


    /**
     *  project management database connection
     */

     protected $connection = 'mysql_second';

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function getTimeDisplayAttribute()
    {
        if (now()->format('Y-m-d') != $this->created_at->format('Y-m-d')) {
            return $this->created_at;
        }

        return $this->created_at->diffForHumans();
    }
}
