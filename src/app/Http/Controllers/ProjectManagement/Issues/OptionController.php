<?php

namespace App\Http\Controllers\ProjectManagement\Issues;

use App\Models\ProjectManagement\Projects\Issue;
use App\Http\Controllers\Controller;
use App\Models\CRM\Person\Person;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function update(Request $request, Issue $issue)
    {
        $issueData = $request->validate([
            'priority_id' => 'required|in:1,2,3',
            'status_id'   => 'required|in:0,1,2,3,4',
            'pic_id'      => 'nullable|exists:users,id',
        ]);
        $issue->priority_id = $issueData['priority_id'];
        $issue->status_id = $issueData['status_id'];
        $issue->pic_id = $issueData['pic_id'];
        $issue->save();
        flash(__('issue.updated'), 'success');

        return back();
    }
}
