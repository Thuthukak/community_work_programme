<?php

namespace App\Http\Controllers\ProjectManagement\Customers;

use App\Models\ProjectManagement\Partners\Customer;
use App\Http\Controllers\Controller;

/**
 * Customer Invoices Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class InvoicesController extends Controller
{
    /**
     * Invoice list of a customer.
     *
     * @param  \App\Entities\Partners\Customer  $customer
     * @return \Illuminate\View\View
     */
    public function index(Customer $customer)
    {
        $invoices = $customer->invoices()->orderBy('date', 'desc')->get();

        return view('customers.invoices', compact('customer', 'invoices'));
    }
}
