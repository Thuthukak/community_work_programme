<?php

namespace App\Models\CRM\KeyResultRecord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class KeyResultRecord extends Model
{
    protected $fillable = [
        'key_results_id',
        'history_value',
        'history_confidence',
    ];

    public function keyresult()
    {
        return $this->belongsTo('App\Models\CRM\KeyResult\KeyResult', 'key_results_id');
    }

    public function accomplishRate()
    {
        return $this->keyresult()->getResults()->historyAcpRate($this->history_value);
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->toDateString();
    }

}

