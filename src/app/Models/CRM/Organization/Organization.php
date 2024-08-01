<?php

namespace App\Models\CRM\Organization;

use App\Models\Core\BaseModel;
use App\Models\CRM\Country\Country;
use App\Models\CRM\File\File;
use App\Models\CRM\Note\Note;
use App\Models\Core\Traits\BootTrait;
use App\Models\Core\Traits\DescriptionGeneratorTrait;
use App\Models\CRM\Organization\Traits\OrganizationRelationshipsTrait;
use App\Models\CRM\Organization\Traits\Rules\OrganizationRules;
use App\Models\CRM\Traits\OpenClosedDealsTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Interfaces\HasObjectiveInterface;
use App\Models\CRM\Objective\traits\HasObjectiveTrait;

class Organization extends BaseModel
{
    use BootTrait {
        boot as traitBoot;
    }
    use OrganizationRelationshipsTrait,
        OrganizationRules,
        // OpenClosedDealsTrait,
        HasObjectiveTrait,
        DescriptionGeneratorTrait;


    protected $fillable = [
        'name',
        'address',
        'country_id',
        'city',
        'state',
        'zip_code',
        'area',
        'contact_type_id',
        'created_by',
        'owner_id'
    ];

    protected static $logAttributes = [
        'name', 'address', 'contactType', 'owner'
    ];

    protected $appends = [
        // 'open_deals',               // See OpenClosedDealsTrait
        // 'closed_deals',             // See OpenClosedDealsTrait
        // 'total_deals',              // See OpenClosedDealsTrait
        // 'total_peoples',            // See OrganizationRelationshipsTrait
        // 'total_followers'           // See OrganizationRelationshipsTrait
    ];

    /**
     * Show project name with link to project detail.
     *
     * @return Illuminate\Support\HtmlString
     */
    public function nameLink()
    {
        return link_to_route('Organizations.show', $this->name, [$this], [
            'title' => __(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => __('project.project')]
            ),
        ]);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    /**
     * Organization has many projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany('App\Models\ProjectManagement\Projects\Project');
    }


     /**
     * Organization has many projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany('App\Models\ProjectManagement\Projects\ProjectJob');
    }

    
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public static function boot()
    {
        parent::boot();

        self::traitBoot();

        static::deleting(function (self $organization) {
            $organization->activity()->delete();
        });
    }

    public function scopePermission(Builder $builder)
    {
        if (auth()->user()->roles[0]->name === 'Agent'){
            $builder->where('owner_id', auth()->id());
        }
    }

}
