<?php

namespace App\Models\Core\File;

use App\Models\Core\BaseModel;
use App\Models\Core\File\Traits\FileRelationship;
use App\Models\Core\File\Traits\FileMethod;
use App\Models\Core\File\Traits\FileAttribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class File
 */
class File extends BaseModel
{
    use FileRelationship, FileMethod, FileAttribute;

    protected $fillable = [
        'path', 'type', 'fileable_id', 'fileable_type', 'type_id', 'filename', 'title', 'description'
    ];

    protected $appends = ['full_url'];

    protected $hidden = [
        'fileable_type', 'fileable_id'
    ];

    protected $enableLoggingModelsEvents = false;


    /**
     * A file belongs to a fileable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * A file belongs to a project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function project(): MorphTo
    {
        return $this->morphTo('fileable', Project::class);
    }

    /**
     * Get the file size.
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->fileExists() ? Storage::size('public/files/' . $this->filename) : 0;
    }

    /**
     * Get the file update date.
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->updated_at->format('Y-m-d');
    }

    /**
     * Get the file update time.
     *
     * @return string
     */
    public function getTime(): string
    {
        return $this->updated_at->format('H:i:s');
    }

    /**
     * Check if the file exists.
     *
     * @return bool
     */
    public function fileExists(): bool
    {
        return Storage::exists('public/files/' . $this->filename);
    }

    /**
     * Delete the file.
     *
     * @return bool|null
     */
    public function delete(): ?bool
    {
        Storage::delete('public/files/' . $this->filename);

        return parent::delete();
    }
}
