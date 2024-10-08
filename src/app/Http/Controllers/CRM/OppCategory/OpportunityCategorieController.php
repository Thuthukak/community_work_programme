<?php

namespace App\Http\Controllers\CRM\OppCategory;

use App\Http\Controllers\Controller;
use App\Models\CRM\OppCategorie\OpportunityCategorie;
use App\Models\CRM\GeneralSettings\GeneralSetting;
use App\Models\CRM\Opportunity\Opportunity;
use Illuminate\Http\Request;

class OpportunityCategorieController extends Controller
{
    public function index($id){
        $jobs = Opportunity::where('category_id', $id)->paginate(15);
        $categoryName = OpportunityCategorie::where('id', $id)->first();
        return view('frontend.jobs.jobs-category', compact('jobs', 'categoryName'));
    }

    public function getAll()
    {
        $categories = OpportunityCategorie::all();
        $gs = GeneralSetting::all()->first();

        return view('crm.categories.index',compact('categories', 'gs'));
    }

    public function show(OpportunityCategorie $categorie)
    {
         // Fetch general settings
        $gs = GeneralSetting::all()->first();
    
        // Pass both $categorie and $gs to the view
        return view('crm.categories.show', compact('categorie', 'gs'));
    }
    

}