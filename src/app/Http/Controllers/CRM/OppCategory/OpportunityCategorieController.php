<?php

namespace App\Http\Controllers\CRM\OppCategory;

use App\Http\Controllers\Controller;
use App\Models\CRM\OppCategory\OpportunityCategorie;
use App\Models\CRM\Opportunity\Opportunity;
use Illuminate\Http\Request;

class OpportunityCategorieController extends Controller
{
    public function index($id){
        $jobs = Opportunity::where('category_id', $id)->paginate(15);
        $categoryName = OpportunityCategorie::where('id', $id)->first();
        return view('frontend.jobs.jobs-category', compact('jobs', 'categoryName'));
    }


}