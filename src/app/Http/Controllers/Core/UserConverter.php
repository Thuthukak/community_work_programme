<?php



namespace App\Http\Controllers\Core;


use App\Models\ProjectManagement\Users\User as ProjectUser;
use App\Models\Core\Auth\User as AuthUser;

class UserConverter {
    public static function convertToProjectUser(AuthUser $authUser): ProjectUser {
        $projectUser = new ProjectUser();
        $projectUser->id = $authUser->id;
        $projectUser->name = $authUser->first_name.' '.$authUser->lastname;
        $projectUser->email = $authUser->email;
        $projectUser->password = $authUser->password;
        $projectUser->remember_token = $authUser->remember_token;
        $projectUser->api_token = $authUser->api_token;
        $projectUser->lang = $authUser->lang;
        $projectUser->created_at = $authUser->created_at;
        $projectUser->updated_at = $authUser->updated_at;
        
        return $projectUser;
    }
}
