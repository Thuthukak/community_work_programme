<?php

namespace App\Filters\CRM;

use App\Filters\CRM\Traits\PublicAccessFilterTrait;
use App\Filters\FilterBuilder;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\CRM\Traits\DateFilterTrait;
use App\Filters\Core\traits\CreatedByFilter;
use DB;

class ActionsFilter extends FilterBuilder
{
    use CreatedByFilter,
        DateFilterTrait;
     
        public function createdAt($startDate = null, $endDate = null)
        {
            if ($startDate && $endDate) {
                // Filter projects where 'created_at' is between startDate and endDate
                $this->builder->whereBetween(\DB::raw('DATE(created_at)'), [$startDate, $endDate]);
            } elseif ($startDate) {
                // Filter projects where 'created_at' is after or on the startDate
                $this->builder->where(\DB::raw('DATE(created_at)'), '>=', $startDate);
            } elseif ($endDate) {
                // Filter projects where 'created_at' is before or on the endDate
                $this->builder->where(\DB::raw('DATE(created_at)'), '<=', $endDate);
            }
            return $this->builder;
        }
        

    public function search($search = null)
    {
        return $this->builder->when($search, function (Builder $builder) use ($search) {
            $builder->where('title', 'LIKE', "%$search%");
        });
    }

    public function belongsTo($ids = null)
    {


        if (is_null($this->builder)) {
            throw new \Exception("Builder is not initialized. Call apply() first.");
        }
        
        $users = explode(',', $ids);
        $this->builder->when($ids, function (Builder $query) use ($users){
            //Filter the query based on the organization relationship
            $query->whereHas('user', function(Builder $query) use ($users)
            {
                $query->whereIn('user_id', $users);
            });
        });
    }
    public function priority($ids = null)
    {
        if (is_null($this->builder)) {
            throw new \Exception("Builder is not initialized. Call apply() first.");
        }
        
        $priorities = explode(',', $ids);
    
        return $this->builder->whereIn('priority', $priorities);  // Directly filter on the priority column
    }
    
    
    public function classes($classes)
    {
        // If $classes is a JSON string, decode it
        if (is_string($classes)) {
            $classes = json_decode($classes, true);
        }
    
        // Ensure $classes is an array
        if (!is_array($classes)) {
            $classes = explode(',', $classes);
        }
    
        if (empty($classes)) {
            return $this->builder;
        }
    
        return $this->builder->when($classes, function (Builder $builder) use ($classes) {
            $builder->where(function (Builder $query) use ($classes) {
                if (in_array('Proposal', $classes)) {
                    $query->orWhereHas('proposals');
                }
                if (in_array('Actions', $classes)) {
                    $query->orWhereHas('actions');
                }
                if (in_array('Objectives', $classes)) {
                    $query->orWhereHas('objectives');
                }
                if (in_array('Projects', $classes)) {
                    $query->orWhereHas('project');
                }
            });
        });
    }
    
}
