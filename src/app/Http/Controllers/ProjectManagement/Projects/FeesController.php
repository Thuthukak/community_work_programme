<?php

namespace App\Http\Controllers\ProjectManagement\Projects;

use App\Models\Payments\Payment;
use App\Models\ProjectManagement\Projects\Project;
use App\Models\CRM\Person\Person;
use App\Models\Users\User;
use App\Http\Controllers\Controller;

/**
 * Project Fees Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class FeesController extends Controller
{
    /**
     * Show create project fee form.
     *
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return \Illuminate\View\View
     */
    public function create(Project $project)
    {
        $this->authorize('create', new Payment());

        $partners = User::pluck('name', 'id')->all();

        return view('crm.projects.fees.create', compact('project', 'partners'));
    }

    /**
     * Store new fee entry to the database.
     *
     * @param  \App\Models\ProjectManagement\Projects\Project  $project
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Project $project)
    {
        $this->authorize('create', new Payment());

        $newPaymentData = request()->validate([
            'type_id' => 'required|numeric',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'partner_id' => 'required|exists:users,id',
            'description' => 'required|string',
        ]);
        $newPaymentData['in_out'] = 0;
        $newPaymentData['project_id'] = $project->id;
        $newPaymentData['partner_type'] = User::class;

        Payment::create($newPaymentData);

        flash(__('payment.created'), 'success');

        return redirect()->route('projects.payments', $project->id);
    }
}
