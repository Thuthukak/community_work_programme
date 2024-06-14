<?php

namespace App\Models\ProjectManagement\Partners;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'notes', 'website', 'is_active'];

 
 
    /**
     * Get status attribute.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->is_active == 1 ? __('app.active') : __('app.in_active');
    }
}
