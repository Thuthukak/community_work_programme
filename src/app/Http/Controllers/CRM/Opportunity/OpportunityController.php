<?php

namespace App\Http\Controllers\CRM\Opportunity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\CRM\JobPostRequest\JobPostRequest;
use App\Models\CRM\OppCategorie\OpportunityCategorie;
use App\Models\CRM\Company\Company;
use App\Models\CRM\GeneralSettings\GeneralSetting;
use App\Models\CRM\Opportunity\Opportunity;
use App\Models\CRM\Organization\Organization;
use App\Models\CRM\JobPost\JobPost;
use App\Models\CRM\Testimonial\Testimonial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OpportunityController extends Controller
{

    public function __construct()
    {
        $this->middleware(['verified'], ['except'=> array('index', 'show', 'apply', 'allJobs', 'category', 'searchJobs')]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $Opportunities = Opportunity::latest()->limit(15)->where('status', 1)->get();
      
        $gs = GeneralSetting::all()->first();

        $organizations = Organization::inRandomOrder()->take(8)->get();


        $jobposts = JobPost::where('status', 1)->get();



        $testimonial = Testimonial::inRandomOrder()->take(12)->get();

        $categories = OpportunityCategorie::where('status', 1)->take(8)->get();

        // dd($categories);

        // $allprosal = Opportunity::has('users')->where('user_id', auth()->user()->id)->get();
        return view('jobopportunity', compact('Opportunities','organizations', 'categories', 'jobposts', 'testimonial','gs'));
    }

    public function loadMoreOrganizations($offset)
    {
        $organizations = Organization::skip($offset)->take(8)->get();
    
        return response()->json($organizations);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobPostRequest $request)
    {

        $user_id = auth()->user()->id;
        $organization = Organization::where('owner_id', $user_id)->first();
        $organization_id = $organization->id;

        // dd($organization);


        Opportunity::create([
            'user_id'=> $user_id,
            'organization_id'=> $organization_id,
            'title' => request('title'),
            'slug' => Str::slug(request('title')),
            'description' => request('description'),
            'roles' => request('roles'),
            'opportunity_categorie_id' => request('category'),
            'position' => request('position'),
            'address' => request('address'),
            'type' => request('type'),
            'experience' => request('experience'),
            'number_of_vacancy' => request('number_of_vacancy'),
            'featured' => 1,
            'status' =>1,
            'gender' => request('gender'),
            'salary' => request('salary'),
            'last_date' => request('last_date'),
        ]);


        return redirect()->back()->with('success', 'Opportunity posted Successfully.');
    }

    /**
     * Display All jobs.
     */
    public function allJobs(Request $request )
    {
        $title = $request->get('title');
        $type = $request->get('type');
        $category = $request->get('category_id');
        $address = $request->get('address');
        
        if($title || $type || $category || $address){
            $jobs = Opportunity::where('title', 'LIKE', '%'.$title.'%')
            ->orWhere('type', $type)
            ->orWhere('category_id', $category)
            ->orWhere('address', $address)
            ->paginate(25);

            return view('frontend.jobs.alljobs', compact('jobs'));
        }else{
    
            $jobs = Opportunity::latest()->paginate(25);
            return view('frontend.jobs.alljobs', compact('jobs'));

        }



    }

    
    /**
     * Display the specified resource.
     */
    public function show( Opportunity $opportunity)
    {

        $opportunityRecommendation = $this->jobRecommendation($opportunity);

        return view('crm.opportunities.show', compact('opportunityRecommendation','opportunity'));
    }

    public function jobRecommendation ($opportunity){
        $data = [];

       $opportunityBasedOnCategory = Opportunity::latest()
                            ->where('opportunity_categorie_id', $opportunity->opportunity_categorie_id)
                            ->whereDate('last_date', '>', date('y-m-d'))
                            ->where('id', '!=', $opportunity->id)
                            ->where('status', 1)
                            ->limit(5)
                            ->get();

        array_push($data, $opportunityBasedOnCategory);

       $opportunityBasedOnCompany = Opportunity::latest()
                            ->where('organization_id', $opportunity->company_id)
                            ->whereDate('last_date', '>', date('y-m-d'))
                            ->where('id', '!=', $opportunity->id)
                            ->where('status', 1)
                            ->limit(5)
                            ->get();
        array_push($data, $opportunityBasedOnCompany);
        $opportunityBasedOnPosition = Opportunity::latest()
                            ->where('position', 'LIKE', '%'.$opportunity->position.'%')
                            ->where('status', 1)
                            ->limit(5);
                            

        array_push($data, $opportunityBasedOnCategory, $opportunityBasedOnCompany, $opportunityBasedOnPosition);

        $collection = collect($data);
        $unique = $collection->unique('id');
        $opportunityRecommendation = $unique->values()->first();
        return $opportunityRecommendation;
    }


    /**
     * Single company all jobs
     */
    public function myjob()
    {
        $jobs = Opportunity::where('user_id', auth()->user()->id)->get();
        return view('frontend.jobs.myjobs', compact('jobs'));
    }

    public function edit($id){
        $job = Opportunity::findOrFail($id);
        return view('frontend.jobs.edit', compact('job'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $job = Opportunity::findOrFail($id);
        $job->update($request->all());
                
        return redirect()->back()->with('success', 'Job updated Successfully.');
    }

    /**
     * Job apply method.
     */
    public function apply(Request $request,$id){

        $jobId = Opportunity::find($id);

        // dd($jobId);
        $jobId->users()->attach(Auth::user()->id);
    
        return redirect()->back()->with('message', 'Job applied Successfully.');
    }


    // public function apply(Request $request)
    //     {
    //         $opportunityId = $request->input('opportunity_id');
    //         $userId = auth()->id();

    //         // Check if the user has already applied
    //         if (Application::where('user_id', $userId)->where('opportunity_id', $opportunityId)->exists()) {
    //             return response()->json(['success' => false, 'message' => 'You have already applied for this opportunity.']);
    //         }

    //         // Apply logic
    //         Application::create([
    //             'user_id' => $userId,
    //             'opportunity_id' => $opportunityId
    //         ]);

    //         return response()->json(['success' => true]);
    //     }


    // Job applicant method 
    public function applicant(){
        $applicants = Opportunity::has('users')->where('user_id', auth()->user()->id)->get();
        return view('frontend.jobs.applicants', compact('applicants'));

    }

    // Search Jobs in 
    public function searchJobs(Request $request){

       
        $keyword = $request->get('keyword');
        $users = Opportunity::where('title','like','%'.$keyword.'%')
                ->orWhere('position','like','%'.$keyword.'%')
                ->orWhere('address','like','%'.$keyword.'%')
                ->get();
        return response()->json($users);

    }

    // Job active/deactive 
    public function jobToggle($id){
        $jobtoggle = Opportunity::find($id);
        $jobtoggle->status = !$jobtoggle->status;
        $jobtoggle->save();

        return redirect('/jobs/myjobs')->with('success', 'Status Updated Successfully!');
    }

    // Job Deleted 
    public function deleteJob(Request $request, string $id){
        $jobDel = Opportunity::find($id);
        $jobDel->delete();
        return redirect('/jobs/create')->with('success', 'Job Deleted Successfully!');
    }


}

