<?php

namespace App\Models\ProjectManagement\Partners;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone', 'pic', 'address', 'website', 'notes', 'is_active'];




    /**
     * Customer has many projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany('App\Models\ProjectManagement\Projects\Project');
    }

   

    /**
     * Customer has many subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany('App\Models\ProjectManagement\Subscriptions\Subscription');
    }

    /**
     * Customer has many invoices through their projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function invoices()
    {
        return $this->hasManyThrough('App\Models\ProjectManagement\Invoices\Invoice', 'App\Models\ProjectManagement\Projects\Project');
    }

    /**
     * Get customer name in html link format.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function nameLink()
    {
        return link_to_route('customers.show', $this->name, [$this->id], [
            'title' => __(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => __('customer.customer')]
            ),
        ]);
    }

    /**
     * Get customr status attribute.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->is_active == 1 ? __('app.active') : __('app.in_active');
    }

    /**
     * Get customr status label attribute.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        $color = $this->is_active == 1 ? ' style="background-color: #337ab7"' : '';

        return '<span class="badge"'.$color.'>'.$this->status.'</span>';
    }
}
