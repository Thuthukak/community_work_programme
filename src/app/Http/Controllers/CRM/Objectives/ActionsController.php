<?php

namespace App\Http\Controllers\CRM\Objectives;

use Storage;
use App\Http\Controllers\Controller;
use App\Models\Core\Auth\User;
use App\Models\CRM\Action\Action;
use App\Models\CRM\Objective\Objective;
use App\Models\CRM\KeyResult\KeyResult;
use App\Models\CRM\Priority\Priority;

use App\Models\ProjectManagement\Projects\Project;
use App\Models\CRM\Pipeline\Pipeline;
use  App\Models\CRM\Proposal\Proposal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CRM\Objectives\ActionRequest;
use Spatie\MediaLibrary\Models\Media;

use Log;

class ActionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $actions = Action::all();

        $data = [
         
            'actions' => $actions,
         ];
    
        return view('crm.actions.index', $data);
    }


    public function create($objective)
    {
        try {
            // Ensure the objective exists
            $objectiveExists = Objective::find($objective);
            if (!$objectiveExists) {
                return response()->json(['error' => 'Objective not found.'], 404);
            }
    
            $priorities = Priority::all();
            $keyresults = KeyResult::where('objective_id', $objective)->get();
    
            // Debugging lines
            Log::info('Priorities:', $priorities->toArray());
            Log::info('Key Results:', $keyresults->toArray());
    
            $data = [
                'objective' => $objective,
                'keyresults' => $keyresults,
                'priorities' => $priorities,
            ];
    
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error in create method:', ['exception' => $e]);
            return response()->json([
                'error' => 'An unexpected error occurred.'
            ], 500);
        }
    }
    

    public  function get()
    {

        try {
            $objectives = Objective::all();
            $priorities = Priority::all();
    
            $data = [
                'objectives' => $objectives,
                'priorities' => $priorities,
            ];
    
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        
    }
    }



    public function listActions()
    {
        $actions = Action::all();

        $this->authorize('view', $actions);

        $okrsWithPage = $company->getOkrsWithPage($request);
        $company['okrs'] = $okrsWithPage['okrs'];

        $data = [
            'user' => auth()->user(),
            'company' => $company,
            'pageInfo' => $okrsWithPage['pageInfo'],
            'order' => $request->input('order', ''),
        ];

        return view('crm.actions.index', $data);
    }
    
    

    // fetch related entity for action selected 

    public function getModels(Request $request ,$actionOn)
    {
        try {
            // Fetch models based on the actionOn value
            $models = [];

          
                if ($actionOn == 'Project') {
                    $models = Project::all(); // Fetch all projects
                } elseif ($actionOn == 'Onboarding') {
                    $models = Pipeline::all(); // Fetch all pipelines
                } elseif ($actionOn == 'Proposal') {
                    $models = Proposal::all(); // Fetch all proposals
                } else {
                    $models = [];
                }
            
                // Return the models as JSON along with the actionOn
                return response()->json([
                    'models' => $models,
                ]);
            
                } catch (\Exception $e) {
            \Log::error("Error fetching models: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    // fetch related key results  for Objective selected 

    public function getKeyResults($id)
    {
        try {
            $keyResults = KeyResult::where('objective_id', $id)->get();
    
            return response()->json($keyResults);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    


    public function store(ActionRequest $request)
    {

        $this->authorize('storeObjective', KeyResult::find($request->krs_id)->objective->model);

        $attr['user_id'] = auth()->user()->id;
        $attr['related_kr'] = $request->input('krs_id');
        $attr['priority'] = $request->input('priority');
        $attr['title'] = $request->input('act_title');
        $attr['content'] = $request->input('act_content');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');
       

        $action = Action::create($attr);

        if ($request->input('invite')) {
            $action->sendInvitation($request);
        }
        if ($request->hasFile('files')) {
            $action->addRelatedFiles();
        }

        // dd($action->priority);

        $objective = $action->objective;

        return redirect()->to($objective->model->getOKrRoute() . '#oid-' . $objective->id);
    }

    public function show(Action $action)
    {

        $user = User::where('id', '=', auth()->user()->id)->first();
        $files = $action->getRelatedFiles();
        $obj = $action->objective;
        $backLink = $obj->model->getOKrRoute() . '#oid-' . $obj->id;
        $data = [
            'backLink' => $backLink,
            'user' => $user,
            'action' => $action,
            'files' => $files,
        ];

        return view('crm.actions.show', $data);
    }

    public function edit(Action $action)
    {
        $this->authorize('update', $action);

        $priorities = Priority::all();
        $user = User::where('id', '=', auth()->user()->id)->first();

        //使用者的krs
        $actions = Action::where('id', '=', $action->id)->get();
        foreach ($actions as $act) {
            $obj_id = $act->keyresult->objective_id;
        }
        $keyresults = KeyResult::where('objective_id', '=', $obj_id)->get();

        $files = $action->getRelatedFiles();

        $data = [
            'user' => $user,
            'actions' => $actions,
            'keyresults' => $keyresults,
            'files' => $files,
            'priorities' => $priorities,
        ];
        return view('crm.actions.edit', $data);
    }

    public function update(ActionRequest $request, Action $action)
    {
        $this->authorize('update', $action);

        if ($request->input('invite') && $request->input('invite') != $action->user_id) {
            $action->sendInvitation($request);
        }

        $attr['related_kr'] = $request->input('krs_id');
        $attr['priority'] = $request->input('priority');
        $attr['title'] = $request->input('act_title');
        $attr['content'] = $request->input('act_content');
        $attr['started_at'] = $request->input('st_date');
        $attr['finished_at'] = $request->input('fin_date');

        $action->update($attr);

        if ($request->hasFile('files')) {
            $action->addRelatedFiles();
        }

        $objective = $action->objective;
        return redirect()->to($objective->model->getOKrRoute() . '#oid-' . $objective->id);
    }

    public function destroy(Action $action)
    {
        $this->authorize('delete', $action);
        $objective = $action->objective;
        $redirectURL = $objective->model->getOKrRoute();
        $action->invitation()->delete();
        $action->delete();

        return redirect()->to($redirectURL . '#oid-' . $objective->id);
    }

    public function destroyFile(Action $action, Media $media)
    {
        $this->authorize('delete', $action);

        $media->delete();
        return redirect()->route('actions.edit', $action);
    }

    public function done(Action $action)
    {
        $this->authorize('update', $action);

        $act = Action::find($action->id);
        if ($act->isdone) $act->isdone = null;
        else $act->isdone = now();
        $act->save();
        return redirect()->back();
    }

    public function search(Objective $objective)
    {
        $results = $objective->model->users;
        return response()->json($results);
    }

    /**
     * 拒絕邀請
     *
     * @param  \App\Project $project
     * @param  \App\Models\Core\Auth\User $member
     * @return \Illuminate\Http\Response
     */
    public function rejectInvite(Action $action, User $member)
    {
        $action->deleteInvitation($member);
        return redirect()->route('user.action', $member->id);
    }

    /**
     * 同意邀請
     *
     * @param  \App\Project $project
     * @param  \App\Models\Core\Auth\User $member
     * @return \Illuminate\Http\Response
     */
    public function agreeInvite(Action $action, User $member)
    {
        $action->deleteInvitation($member);
        $attr['user_id'] = $member->id;
        $action->update($attr);
        return redirect()->route('user.action', $member->id);
    }



}
