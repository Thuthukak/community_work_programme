<?php

namespace App\Models\CRM\Action\traits;

use App\Models\CRM\Action\Action;
use Illuminate\Http\Request;
use Notification;
use App\Notifications\CRM\Objective\NewObjectiveNotification;
use App\Models\CRM\Company\Company;
use App\Models\CRM\Organization\Organization;
use App\Models\ProjectManagement\Projects\Project;

trait HasActionTrait
{
    /**
     * Returns all objectives for this model.
     */
    public function actions()
    {
        return $this->morphMany(Action::class, 'model');
    }

    
    protected function Company()
    {
        return $this->belongsTo(Company::class , 'cotextable');
    }
    

    // public function addAction(Request $request, $model = null)
    // {
    //     $attr['model_id'] = $this->id;
    //     $attr['model_type'] = get_class($this);
    //     $attr['title'] = $request->input('obj_title');
    //     $attr['started_at'] = $request->input('st_date');
    //     $attr['finished_at'] = $request->input('fin_date');
    //     $objective = Objective::create($attr);

    //     if ($model) {
    //         if (get_class($model) == Project::class) {
    //             $users = $model->users()->where('user_id', '!=', auth()->user()->id)->get();
    //         } else {
    //             $users = $model->users()->where('id', '!=', auth()->user()->id)->get();
    //         }
    //         Notification::send($users, new NewObjectiveNotification($model, $objective));
    //     }

    //     return $objective;
    // }

    // public function hasObjectives()
    // {
    //     return count($this->objectives()->get()) ? true : false;
    // }

    public function getActionsBuilder(Request $request)
    {
        $builder = $this->actions();
        // dd($builder);
        # If a search is performed, then run this judgment
        if ($request->input('st_date', '') || $request->input('fin_date', '')) {
            # Check if the start date search is empty.        
            if ($search = $request->input('st_date', '')) {
                $builder->where(function ($query) use ($search) {
                    $query->where('finished_at', '>=', $search);
                });
            }
            # Check if the end date search is empty.        
            if ($search = $request->input('fin_date', '')) {
                $builder->where(function ($query) use ($search) {
                    $query->where('started_at', '<=', $search);
                });
            }
            # Determine whether to use built-in sorting or not
            if ($order = $request->input('order', '')) { 
                # Determine if the value ends with _asc or _desc for sorting
                if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                    # Determine if it is one of the specified received parameters.
                    if (in_array($m[1], ['started_at', 'finished_at', 'updated_at'])) {   
                        # Start sorting              
                        $builder->orderBy($m[1], $m[2]);
                    }
                }
            }
        } else {
            $now = now()->toDateString();
            $builder->where('started_at', '<=', $now)
                ->where('finished_at', '>=', $now)
                ->orderBy('finished_at');
        }
        return $builder;
    }

    public function getPages(Request $request)
    {
        $builder = $this->getActionsBuilder($request);
        // dd($builder);

        $pages = $builder->paginate(4)->appends([
            'st_date' => $request->input('st_date', ''),
            'fin_date' => $request->input('fin_date', ''),
            'order' => $request->input('order', '')
        ]);


        return $pages;
    }

    public function getOkrsWithPage(Request $request)
    {


        $okrs = [];
        $pages = $this->getPages($request);

        foreach ($pages as $obj) {
            $okrs[] = [
                "actions" => $obj->actions,
            ];
        }

        return [
            'okrs' => $okrs,
            'pageInfo' => [
                'link' => $pages->render(),
                'totalItem' => $pages->total()
            ]
        ];
    }

    public function countObjective()
    {
        return count($this->objectives);
    }

    public function countKRs()
    {
        $sum = 0;
        foreach ($this->objectives as $objective) {
            $sum += count($objective->keyresults);
        }

        return $sum;
    }

    public function complianceRate()
    {
        $complianceRate = [0, 0, 0, 0];
        $sum = 0;
        foreach ($this->objectives as $objective) {
            $complianceRate[3]++;
            if ($objective->getScore() < 100) $complianceRate[2]++;
            if ($objective->getScore() < 75) $complianceRate[1]++;
            if ($objective->getScore() < 50) $complianceRate[0]++;
            $sum++;
        }
        if ($sum == 0) return [0, 0, 0, 0];
        else {
            foreach ($complianceRate as $index => $item) {
                $complianceRate[$index] = $item / $sum;
            }
            return $complianceRate;
        }
    }

    public function complianceRateAvg()
    {
        $sum = 0;
        foreach ($this->objectives as $objective) {
            $sum += $objective->getScore();
        }
        if (count($this->objectives) == 0) return 0;
        else return $sum/count($this->objectives);
    }
}
