<?php

namespace App\Http\Controllers\CRM\Objectives;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ObjectiveRequest;
use App\Http\Requests\KeyResultRequest;
use App\Models\Core\Auth\User;
use App\Models\CRM\Organization\Organization;
use App\Models\CRM\Objective\Objective;
use App\Models\CRM\KeyResult\KeyResult;
use App\Models\CRM\Company\Company;
use App\Models\CRM\KeyResultRecord\KeyResultRecord;
use DB;
class OkrController extends Controller
{
    /**
     * 要登入才能用的Controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



           /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listOKR(Request $request)
    {
        //   dd(auth()->user()->id);

        DB::enableQueryLog(); // Enable query log

        $company = company::where('user_id', auth()->user()->id)->first();

                // dd(DB::getQueryLog()); // Show results of log

        $this->authorize('view', $company);

        $okrsWithPage = $company->getOkrsWithPage($request);
        $company['okrs'] = $okrsWithPage['okrs'];    
        $routeObjectiveStore = route('user.objective.store', auth()->user()->id);


        $data = [
            'user' => auth()->user(),
            'company' => $company,
            'pageInfo' => $okrsWithPage['pageInfo'],
            'st_date' => $request->input('st_date', ''),
            'fin_date' => $request->input('fin_date', ''),
            'order' => $request->input('order', ''),
            'routeObjectiveStore' => $routeObjectiveStore,
        ];
        // dd($data);


        return view('crm.organization.company.okr', $data);
    }

    public function edit(Objective $objective)
    {
        $this->authorize('storeObjective', $objective->model);

        $user = User::where('id', '=', auth()->user()->id)->first();        
        //使用者的krs
        $keyresults = KeyResult::where('objective_id', '=', $objective->id)->get();
        $data = [
            'owner' => $user,
            'objective' => $objective,
            'keyresults' => $keyresults,
        ];
        return view('okrs.edit', $data);
    }

    public function update(Request $request, Objective $objective)
    {
        $this->authorize('storeObjective', $objective->model);

        $objAttr = [];
        if($request->exists('obj_title')) $objAttr['title'] = $request->input('obj_title');
        if($request->exists('st_date')) $objAttr['started_at'] = $request->input('st_date');
        if($request->exists('fin_date')) $objAttr['finished_at'] = $request->input('fin_date');
        $objective->update($objAttr);

        $keyresults = KeyResult::where('objective_id', '=', $objective->id)->get();
        foreach ($keyresults as $keyresult) {
            if($request->exists('krs_title' . $keyresult->id)){
                $krAttr['title'] = $request->input('krs_title' . $keyresult->id);
                $krAttr['confidence'] = $request->input('krs_conf' . $keyresult->id);
                $krAttr['initial_value'] = $request->input('krs_init' . $keyresult->id);
                $krAttr['target_value'] = $request->input('krs_tar' . $keyresult->id);
                $krAttr['current_value'] = $request->input('krs_now' . $keyresult->id);
                $krAttr['weight'] = $request->input('krs_weight' . $keyresult->id);
                // if( $krAttr['current_value']!=$keyresult->current_value ||$krAttr['confidence']!=$keyresult->confidence){
                // $oldAttr['key_results_id'] = $keyresult->id;
                // $oldAttr['history_confidence'] = $keyresult->confidence;
                // $oldAttr['history_value'] = $keyresult->current_value;
                // KeyResultRecord::create($oldAttr);
                $keyresult->update($krAttr);
            }
        }

        return redirect()->to($objective->model->getOKrRoute() . '#oid-' . $objective->id);
    }
}
