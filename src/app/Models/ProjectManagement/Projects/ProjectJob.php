<?php

namespace App\Models\ProjectManagement\Projects;

use App\Models\Core\Auth\User;
use App\Models\CRM\Person\Person;
use DB;
use App\Models\CRM\Organization\Organization;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

/**
 * ProjectJob Model.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class ProjectJob extends Model
{
    use PresentableTrait;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => 'App\Events\Jobs\Created',
        'updated' => 'App\Events\Jobs\Updated',
        'deleted' => 'App\Events\Jobs\Deleted',
    ];


    protected $table = 'ProjectJobs';


    /**
     * @var \App\Models\ProjectManagement\Projects\JobPresenter
     */
    protected $presenter = JobPresenter::class;

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Show job name with link to job detail.
     *
     * @return Illuminate\Support\HtmlString
     */
    public function nameLink()
    {
        return link_to_route('jobs.show', $this->name, [$this->id], [
            'title' => __(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => __('ProjectJobs.ProjectJobs')]
            ),
        ]);
    }

    /**
     * Job belongs to a Project relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Job belongs to a Person relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    /**
     * Job has many Tasks relation ordered by position.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('position');
    }

        /**
     * Project belongs to a Organization relation.
     *
     * @return \Illuminate\Database\Eloquent\Concerns\belongsTo
     */
    public function Organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Job has many comments relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the job type.
     *
     * @return string
     */
    public function type()
    {
        return $this->type_id == 1 ? __('job.main') : __('job.additional');
    }

    /**
     * Add progress attribute on Job model.
     *
     * @return int
     */
    public function getProgressAttribute()
    {
        return $this->tasks->isEmpty() ? 0 : $this->tasks->avg('progress');
    }

    /**
     * Add receiveable_earning attribute on Job model.
     *
     * @return float
     */
    public function getReceiveableEarningAttribute()
    {
        return $this->price * ($this->progress / 100);
    }

    /**
     * Delete the model from the database.
     *
     * @return bool|null
     */
    public function delete()
    {
        DB::beginTransaction();
        $this->tasks()->delete();
        $this->comments()->delete();
        DB::commit();

        return parent::delete();
    }
}
