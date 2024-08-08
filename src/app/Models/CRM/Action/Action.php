<?php

namespace App\Models\CRM\Action;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
// use Laravelista\Comments\Commentable;
use App\Models\Core\Auth\User;
use App\Models\CRM\Priority\Priority;
use App\Models\CRM\Objective\Objective;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Models\Media;
use App\Interfaces\HasNotifiableInterface;
use App\Interfaces\HasInvitationInterface;
// use App\Traits\HasInvitationTrait;
use App\Models\CRM\Avatar\traits\HasAvatarTrait;

class Action extends Model implements HasMedia, HasNotifiableInterface, HasInvitationInterface
{
    use  InteractsWithMedia, HasAvatarTrait;

    protected $fillable = [
        'user_id',
        'related_kr',
        'priority',
        'isdone',
        'title',
        'content',
        'started_at',
        'finished_at',
        'model_id',
        'model_type',
    ];
    protected $touches = ['objective'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function objective()
    {
        return $this->keyresult->belongsTo(Objective::class);
    }


    public function getActionRoute()
    {
        return route('actions.action');
    }

    public function keyresult()
    {
        return $this->belongsTo('App\Models\CRM\KeyResult\KeyResult', 'related_kr');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }


    public function getOKrRoute()
    {
        return route('actions.okr');
    }
    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priority');
    }

    public function addRelatedFiles()
    {
        $this->addAllMediaFromRequest()->each(function ($fileAdder) {
            $fileAdder->sanitizingFileName(function ($fileName) {
                return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
            })->toMediaCollection();
        });
    }

    public function getRelatedFileNames()
    {
        $file_names = [];

        $media = $this->getMedia();
        foreach ($media as $m) {
            $file_names[] = $m->file_name;
        }

        return $file_names;
    }

    public function getRelatedFiles()
    {
        $files = [];

        $media = $this->getMedia();
        foreach ($media as $m) {
            $files[] = [
                'media_id' => $m->id,
                'name' => $m->file_name,
                'url' => $m->getUrl(),
                'updated_at' => $m->updated_at->format('Y-m-d H:i:s')
            ];
        }

        return $files;
    }

    public function getNotifiable()
    {
        return $this->user;
    }

    public function getHasCommentMessage()
    {
        return 'Action ' . $this->title;
    }

    public function getInviteUrl($userId)
    {
        return route('user.action', $userId);
    }

    public function getUrl()
    {
        return route('actions.show', $this->id);
    }
}

