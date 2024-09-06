<?php

namespace App\Filters\CRM;

use App\Filters\CRM\Traits\PublicAccessFilterTrait;
use App\Filters\FilterBuilder;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\CRM\Traits\DateFilterTrait;
use App\Filters\Core\traits\CreatedByFilter;

class ProjectsFilter extends FilterBuilder
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
            $builder->where('subject', 'LIKE', "%$search%");
        });
    }

    public function organization($ids = null)
    {

        if (is_null($this->builder)) {
            throw new \Exception("Builder is not initialized. Call apply() first.");
        }
        
        $organizations = explode(',', $ids);
        $this->builder->when($ids, function (Builder $query) use ($organizations){
            //Filter the query based on the organization relationship
            $query->whereHas('organization', function(Builder $query) use ($organizations)
            {
                $query->whereIn('organization_id', $organizations);
            });
        });
    }
    public function projectValue($minValue = null, $maxValue = null)
    {
        return $this->builder->when($minValue && $maxValue, function (Builder $builder) use ($minValue, $maxValue) {
            $builder->whereBetween('project_value', [$minValue, $maxValue]);
        });
    }
    
    public function classes(array $classes = [])
    {

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
            });
        });
    }
}
