<?php

namespace App\Filters\CRM;

use App\Filters\CRM\Traits\PublicAccessFilterTrait;
use App\Filters\FilterBuilder;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\CRM\Traits\DateFilterTrait;
use App\Filters\Core\traits\CreatedByFilter;

class TasksFilter extends FilterBuilder
{
    use CreatedByFilter,
        DateFilterTrait;
     
    // public function createdAt()
    // {
    //     $date = request()->created_at;

    //     $this->builder->when($date, function (Builder $builder) use ($date) {
    //         $builder->whereBetween(\DB::raw('DATE(created_at)'), array_values($date));
    //     });

    //     return $this->builder;
    // }

    public function search($search = null)
    {
        return $this->builder->when($search, function (Builder $builder) use ($search) {
            $builder->where('name', 'LIKE', "%$search%");
        });
    }

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

        public function organization($ids = null)
        {
            if (is_null($this->builder)) {
                throw new \Exception("Builder is not initialized. Call apply() first.");
            }

            $organizations = explode(',', $ids);
            $this->builder->when($ids, function (Builder $query) use ($organizations) {
                // Filter the query to find tasks through the projects belonging to the organization
                $query->whereHas('project', function (Builder $query) use ($organizations) {
                    $query->whereHas('organization', function (Builder $query) use ($organizations) {
                        $query->whereIn('id', $organizations);
                    });
                })
                // Eager load the tasks related to those filtered projects
                ->with(['project.tasks']);
            });
        }

        

    public function tasks($ids = null)
    {
        $tasks = explode(',', $ids);
        $this->builder->when($ids, function (Builder $query) use ($tasks) {
            // Filter the query based on the project relationship
            $query->whereHas('project', function (Builder $query) use ($tasks) {
                $query->whereIn('id', $tasks); // Assuming 'id' is the primary key of the project
            })
            ->with('tasks'); // Eager load the subtasks relationship
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
    

   

    public function ProjectWithOther(array $other = null)
    {
        if (empty($other)) {
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
