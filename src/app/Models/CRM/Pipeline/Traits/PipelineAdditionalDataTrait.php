<?php

namespace App\Models\CRM\Pipeline\Traits;

use App\Models\CRM\Person\Person;
use App\Models\Core\Auth\User;
use Illuminate\Database\Eloquent\Builder;

trait PipelineAdditionalDataTrait
{
    /*
     * Get total stages
     */
    public function getTotalStagesAttribute()
    {
        return (int) $this->stage()->count();
    }

    /*
     * Get total deals
     */
    public function getTotalDealsAttribute()
    {
        return (int) $this->deals()->count();
    }

    /*
     * Get the summation of deal values
     */
    public function getTotalDealValueAttribute()
    {
        if (!app()->runningInConsole()) {
            $user = auth()->user() ?? User::find(1); // Use authenticated user or fallback to admin (id = 1)

            if (request()->has('clientRoleAccess')) {
                $personId = Person::where('attach_login_user_id', $user->id)->first()->id;

                return (int) $this->deals()
                    ->whereHas('contactPerson', function (Builder $query) use ($personId) {
                        $query->where('person_id', '=', $personId);
                    })
                    ->sum('value');
            }

            // Check if user has permission, or fallback to admin user (id = 1)
            if ($user->can('manage_public_access')) {
                return (int) $this->deals()->sum('value');
            }

            // Restrict the query if the user doesn't have permission
            return (int) $this->deals()
                ->where('created_by', $user->id)
                ->sum('value');
        }
    }
}
