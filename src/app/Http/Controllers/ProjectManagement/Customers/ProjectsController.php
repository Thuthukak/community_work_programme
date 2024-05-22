<?php

namespace App\Http\Controllers\ProjectManagement\Customers;

use App\Models\Partners\Customer;
use App\Http\Controllers\Controller;

/**
 * Customer Projects Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class ProjectsController extends Controller
{
    /**
     * Project list of a customer.
     *
     * @param  \App\Entities\Partners\Customer  $customer
     * @return \Illuminate\View\View
     */
    public function index(Customer $customer)
    {
        $projects = $customer->projects;

        return view('customers.projects', compact('customer', 'projects'));
    }
}
