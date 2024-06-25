<?php

namespace App\Models\ProjectManagement;

use App\Models\ProjectManagement\Partners\Customer;
use App\Models\ProjectManagement\Projects\ProjectJob;
use App\Models\CRM\Person\Person;
use App\Models\Core\Auth\User;
use App\Models\CRM\Organization\Organization;
/**
 * Base Repository Class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
abstract class BaseRepository extends EloquentRepository
{
    /**
     * Get collection of customers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCustomersList()
    {
        return Customers::where('is_active', 1)
            ->orderBy('name')
            ->pluck('name', 'id');
    }


    /**
     * Get collection of customers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPersonsList()
    {
        return Person::orderBy('name')
        ->pluck('name', 'id');
    }

     /**
     * Get collection of customers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOrganizationsList()
    {
        return Organization::orderBy('name')
        ->pluck('name', 'id');
    
    }

        /**
     * Get collection of customers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOrganizationsById($organizationId)
    {
        return Organization::findOrFail($organizationId);

    }
   
        /**
         * Get collection of persons with first name and last name concatenated.
         *
         * @return \Illuminate\Support\Collection
         */
        public function getWorkersList()
        {
            return User::orderBy('first_name')
                        ->orderBy('last_name')
                        ->get()
                        ->map(function ($user) {
                            return [
                                'id' => $user->id,
                                'name' => $user->first_name . ' ' . $user->last_name,
                            ];
                        })
                        ->pluck('name', 'id');
        }


        /**
         * Get collection of persons with first name and last name concatenated.
         *
         * @return \Illuminate\Support\Collection
         */
        public function getPersonsLists()
        {
            return User::orderBy('first_name')
                        ->orderBy('last_name')
                        ->get()
                        ->map(function ($user) {
                            return [
                                'id' => $user->id,
                                'name' => $user->first_name . ' ' . $user->last_name,
                            ];
                        })
                        ->pluck('name', 'id');
        }


    /**
     * Get Job by it's id.
     *
     * @param  int  $jobId
     * @return \App\Models\ProjectManagement\Projects\ProjectJob
     */
    public function requireJobById($jobId)
    {
        return ProjectJob::findOrFail($jobId);
    }
}
