<?php

namespace App\Http\Controllers\ProjectManagement\Users;

use App\Models\Core\Auth\Users\User;
use App\Http\Controllers\Controller;
use App\Queries\AdminDashboardQuery;

/**
 * User Jobs Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class JobsController extends Controller
{
    public function index(User $user)
    {
        $jobs = (new AdminDashboardQuery())->onProgressJobs($user, ['project']);

        return view('users.jobs', compact('user', 'jobs'));
    }
}
