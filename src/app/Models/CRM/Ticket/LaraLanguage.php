<?php

namespace App\Models\CRM\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LaraLanguage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function laraTranslation(): HasOne
    {
        return $this->hasOne(LaraTranslation::class);
    }
}
