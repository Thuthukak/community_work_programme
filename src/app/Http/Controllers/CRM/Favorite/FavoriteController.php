<?php

namespace App\Http\Controllers\CRM\Favorite;

use App\Models\CRM\Opportunity\Opportunity;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Save Job in favorite table
     */
    public function saveJob(Request $request,$id)
    {
    	$jobId = Opportunity::find($id);
    	$jobId->favorites()->attach(auth()->user()->id);
    	return redirect()->back();
    }
    /**
     * Un Save Job in favorite table
     */
    public function unSaveJob(Request $request,$id)
    {
    	$jobId = Opportunity::find($id);
    	$jobId->favorites()->detach(auth()->user()->id);
    	return redirect()->back();
    }


}
