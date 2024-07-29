<?php

namespace App\Models\CRM\KeyResult;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\Objective\Objective;

class KeyResult extends Model
{

    // 紀錄KR更新，表示該張O有定期更新
    protected $touches = ['objective'];

    protected $fillable = [
        'objective_id',
        'title',
        'confidence',
        'initial_value',
        'target_value',
        'current_value',
        'weight',
    ];

    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }

    public function keyResultRecords()
    {
        return $this->hasMany(App\Models\CRM\KeyResultRecord\KeyResultRecord::class);
    }

    public function actions()
    {
        return $this->hasMany(App\Models\CRM\Action\Action::class);
    }

    public function color()
    {
        #定義 kr 標籤顏色
        $colors = ['#06d6a0', '#ef476f', '#ffd166', '#6eeb83', '#f7b32b', '#fcf6b1', '#a9e5bb', '#59c3c3', '#d81159'];
        return $colors[($this->id) % 9];
    }

    public function accomplishRate()
    {
        if ($this->target_value == $this->initial_value)
            return 0;
        else if ($this->target_value > $this->initial_value)
            return round(($this->current_value - $this->initial_value) * 100 / ($this->target_value - $this->initial_value), 0);
        else if ($this->target_value < $this->initial_value)
            return round(($this->initial_value - $this->current_value) * 100 / ($this->initial_value - $this->target_value), 0);
    }

    public function historyAcpRate($current_value)
    {
        if ($this->target_value == $this->initial_value)
            return 0;
        else if ($this->target_value > $this->initial_value)
            return round(($current_value - $this->initial_value) * 100 / ($this->target_value - $this->initial_value), 0);
        else if ($this->target_value < $this->initial_value)
            return round(($this->initial_value - $current_value) * 100 / ($this->initial_value - $this->target_value), 0);
    }
}
