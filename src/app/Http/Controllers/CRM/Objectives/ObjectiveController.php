<?php

namespace App\Http\Controllers\CRM\Objectives;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Core\Auth\User;
use App\Models\CRM\Objective\Objective;

class ObjectiveController extends Controller
{
    /**
     * 要登入才能用的Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Objective $objective
     * @return \Illuminate\Http\Response
     */
    public function destroy(Objective $objective)
    {
        $this->authorize('storeObjective', $objective->model);       
        $objective->delete();
        return redirect()->back();
    }

    public function getArray(Objective $objective)
    {
        return $objective->getRelatedKrRecord();
    }
}
