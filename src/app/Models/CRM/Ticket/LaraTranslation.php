<?php

namespace App\Models\CRM\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaraTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['lara_language_id', 'key', 'locale', 'group', 'value'];

    protected $with = [
        'laraLanguage',
    ];

    public function laraLanguage(): BelongsTo
    {
        return $this->belongsTo(LaraLanguage::class);
    }

    public function getEnLanguage($key)
    {
        return self::where('locale', 'en')->where('key', $key)->first()->value;
    }

    /*public static function getGroupsForLanguage($language)
    {
        return static::whereNotNull('group')
            ->where('group', 'not like', '%single')
            ->select('group')
            ->distinct()
            ->get();
    }*/
}
