<?php

namespace App\Http\Controllers\ProjectManagement\Users;

use App\Models\Users\User;
use App\Http\Controllers\Controller;

/**
 * User Projects Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class ProjectsController extends Controller
{
    public function index(User $user)
    {

        
        $user = $this->convertToProjectManagementUser(auth()->user());

        
        $projects = $user->projects()
            ->where(function ($query) {
                $query->where('projects.name', 'like', '%'.request('q').'%');
                $query->where('status_id', request('status', 2));
            })
            ->latest()
            ->with(['customer'])
            ->paginate();

        return view('users.projects', compact('user', 'projects'));
    }

   

    private function convertToProjectManagementUser($user)
    {
        // Assuming the User models are interchangeable and you can simply return it
        // If not, you might need to create a new instance and map properties accordingly
        return new User([
            'id' => $user->id,
            'name' => $user->first_name,
            'email' => $user->email,
            "password" => $user->password,
            "remember_token" => $user->remember_token,
            "lang" => $user->lang,
            "lang" => $user->lang,
            "created_at" => $user->created_at,
            "updated_at" => $user->updated_at
            // map other properties as needed
        ]);
    } 
}


