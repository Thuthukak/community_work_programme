<?php
namespace App\Models\CRM\File;

use App\Models\Core\File\File as CoreFile;

class File extends CoreFile
{
    protected $appends = ['icon'];

    public function getIconAttribute()
    {
        return config('crm-config.icon.for_file_icon');
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Merge the appends from the parent class
        $this->appends = array_merge(['icon'], $this->appends);
    }
}
