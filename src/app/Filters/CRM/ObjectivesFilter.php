<?php

namespace App\Filters\CRM;

use App\Filters\CRM\Traits\PublicAccessFilterTrait;
use App\Filters\FilterBuilder;
use App\Filters\CRM\Traits\DateFilterTrait;
use App\Filters\Core\traits\CreatedByFilter;
use DB;

class ObjectivesFilter extends FilterBuilder
{

    use CreatedByFilter,
        DateFilterTrait;


        public function createAt($startDate=  null, $endDate = null)
        {
            if($startDate && $endDate){
                $this->builder->whereBetween(\DB::raw('DATE(created_at)'),[$startDate,$endDate]);

            }elseif($startDate)
            {
                $this->builder->where(\DB::raw('DATE(created_at'), '>=', $startDate);

            }elseif($endDate)
            {
                $this-builder(\DB::raw('DATE(created_at'),'<=',$endDate);
            }
        }

        public function search($search = null)
        {
            return $this->builder->when($search, function(Builder $builder) use ($search){
                $builder->where('title', 'LIKE',"%$searche");

            });
        }

        public function organizationType($OrganizationIds = null)

        {

        }   
 }