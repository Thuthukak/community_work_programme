<?php

namespace App\Policies\Partners;

use App\Entities\Partners\Vendor;
use App\Models\Core\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Vendor model policy class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class VendorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the vendor.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Entities\Partners\Vendor  $vendor
     * @return mixed
     */
    public function view(User $user, Vendor $vendor)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create vendors.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Entities\Partners\Vendor  $vendor
     * @return mixed
     */
    public function create(User $user, Vendor $vendor)
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the vendor.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Entities\Partners\Vendor  $vendor
     * @return mixed
     */
    public function update(User $user, Vendor $vendor)
    {
        return $this->view($user, $vendor);
    }

    /**
     * Determine whether the user can delete the vendor.
     *
     * @param  \App\Models\ProjectManagement\Users\User  $user
     * @param  \App\Entities\Partners\Vendor  $vendor
     * @return mixed
     */
    public function delete(User $user, Vendor $vendor)
    {
        return $user->hasRole('admin');
    }
}
