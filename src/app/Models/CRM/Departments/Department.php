<?php

namespace App\Models\CRM\Departments;

use App\Models\Core\Auth\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\Ticket\Ticket;
use App\Models\CRM\Ticket\KnowledgeBase;

class Department extends Model
{
    protected $guarded = [];


    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function knowledgeBase()
    {
        return $this->hasMany(KnowledgeBase::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function posts()
    {
        return $this->hasMany(KnowledgeBase::class,'department_id');
    }
}
