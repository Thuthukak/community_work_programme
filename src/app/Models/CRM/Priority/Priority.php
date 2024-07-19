<?php

namespace App\Models\CRM\Priority;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $fillable = [
        'priority', 'color',
    ];
    public function actions()
    {
        return $this->hasMany(App\Models\CRM\Action\Action::class);
    }
}

