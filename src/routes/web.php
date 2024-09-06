<?php
use App\Http\Controllers\CRM\LeadWebFormController;
use App\Http\Controllers\Core\LanguageController;
use App\Http\Controllers\InstallDemoDataController;
use App\Http\Controllers\ProjectManagement\Projects\ProjectsController;
use App\Http\Controllers\ProjectManagement\Projects\JobsController;
use App\Http\Controllers\ProjectManagement\Projects\ActivityController;
use App\Http\Controllers\ProjectManagement\Projects\IssueController;
use App\Http\Controllers\ProjectManagement\Projects\CommentsController;
use App\Http\Controllers\ProjectManagement\Projects\FilesController;
use App\Http\Controllers\ProjectManagement\SubscriptionsController;
use App\Http\Controllers\API\ProjectJobsController;
use App\Http\Controllers\ProjectManagement\Issues\OptionController;
use App\Http\Controllers\ProjectManagement\IssueController as IssuesController;
use App\Http\Controllers\ProjectManagement\Projects\TasksController;
use App\Http\Controllers\CRM\Contact\OrganizationController;
use App\Models\Core\Auth\User;
use App\Http\Controllers\Core\Auth\User\UserController;
use App\Http\Controllers\CRM\Objectives\OkrController;
use App\Http\Controllers\CRM\Objectives\KrController;
use App\Http\Controllers\CRM\Objectives\FollowController;
use App\Http\Controllers\CRM\Objectives\CompanyController;
use App\Http\Controllers\CRM\Ticket\TicketsController;
use App\Http\Controllers\CRM\Department\DepartmentsController;
use App\Http\Controllers\CRM\Objectives\ActionsController;
use App\Http\Controllers\Core\HomeController;
use Illuminate\Support\Facades\Route;

// Root route
Route::get('/', function () {
    if (auth()->check()) {
        $user = User::with(['roles'])->where('id', auth()->id())->first();
        if ($user->hasRole(['Agent'])) {
            return redirect(route('persons.lists'));
        } elseif ($user->hasRole(['Client'])) {
            return redirect(route('organizations.lists'));
        }
    }

    return redirect('/Home');
});


Route::get('/Home', [HomeController::class,'index'])->name('homePage');

// Documentation routes
Route::get('doc/core/components', [\App\Http\Controllers\DocumentationController::class, 'index']);
Route::get('doc/core/components/{component_name}', [\App\Http\Controllers\DocumentationController::class, 'show']);

// Test routes
Route::post('test-component', [\App\Http\Controllers\TestingController::class, 'test']);
Route::get('test-component', [\App\Http\Controllers\TestingController::class, 'testValue']);
Route::get('get-test-chart', [\App\Http\Controllers\TestingController::class, 'getTestChart']);
Route::get('dynamic-contnent/{id}', [\App\Http\Controllers\TestingController::class, 'getDynamicValue']);
Route::post('store', [\App\Http\Controllers\TestingController::class, 'store'])->name('store');
Route::get('test-value', [\App\Http\Controllers\TestingController::class, 'getTestValue'])->name('test-value');
Route::get('test-cards', [\App\Http\Controllers\TestingController::class, 'getCardDataForTest'])->name('test-cards');
Route::get('test-calendar-events', [\App\Http\Controllers\TestingController::class, 'getCalendarEventForTest'])->name('test-calendar-events');

// Language switcher
Route::get('lang/{lang}', [LanguageController::class, 'swap'])->name('language.change');

// User-related routes for guest users
Route::group(['middleware' => 'guest', 'prefix' => 'users'], function () {
    include_route_files(__DIR__ . '/user/');
});
Route::group(['middleware' => 'guest', 'prefix' => 'admin/users'], function () {
    include_route_files(__DIR__ . '/login/');
});

// Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'authorize']], function () {
    include __DIR__ . '/additional.php';
});
Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'core.'], function () {
    include_route_files(__DIR__ . '/core/');
});

// CRM-related routes
Route::group(['middleware' => 'admin'], function () {
    include_route_files(__DIR__ . '/CRM/');
});
Route::group(['middleware' => ['auth', 'authorize']], function () {
    include_route_files(__DIR__ . '/support/');
});

// Demo data installation
Route::any('install-demo-data', [InstallDemoDataController::class, 'run'])->name('install-demo-data');

// Email routes
Route::get('email/inbox', function () {
    return view('email.inbox');
})->name('email-inbox');
Route::get('email/compose', function () {
    return view('email.compose');
})->name('email-compose');

// QA script// QA script for storage link creation
Route::get('link', function () {
    $target = storage_path("app/public");
    $explode_base_path = explode(DIRECTORY_SEPARATOR, base_path());
    array_pop($explode_base_path);
    array_push($explode_base_path, 'storage');
    $path = implode(DIRECTORY_SEPARATOR, $explode_base_path);
    symlink($target, $path);
    return true;
});

// Lead web form routes
Route::get('lead-web-form', [LeadWebFormController::class, 'leadWebForm'])->name('lead.web-form');
Route::get('lead-web-form-custom-fields', [LeadWebFormController::class, 'webFormCustomFields'])->name('lead.web-form-custom-fields');
Route::post('lead-web-form/create', [LeadWebFormController::class, 'store'])->name('lead-web-form.store');
Route::get('phone-email-types', [LeadWebFormController::class, 'phoneEmailTypes'])->name('phone_email_types.web-form');
Route::get('countries', [LeadWebFormController::class, 'countries'])->name('countries.web-form');

// Proposal route
Route::get('proposal', function () {
    $proposal = \App\Models\CRM\Proposal\Proposal::query()->orderByDesc('id')->with('files')->first();
    return public_path($proposal->files[0]['path']);
});
// Customer routes
// Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
// Route::get('customers/{customer}/projects', [CustomerController::class, 'projects'])->name('customers.projects');
// Route::get('customers/{customer}/subscriptions', [CustomerController::class, 'subscriptions'])->name('customers.subscriptions');

// Project routes

// Route::resource('projects', [ProjectsController::class]);

//Project filters 

Route::get('/projects/all'  , [ProjectsController::class, 'getProjectByFilter'])->name('projects.get');
Route::get('/projects/list'  , [ProjectsController::class, 'getProjects'])->name('projects.list');

Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
Route::get('projects/create', [ProjectsController::class, 'create'])->name('projects.create');
Route::get('projects/{project}/delete', [ProjectsController::class, 'delete'])->name('projects.delete');
Route::get('projects/destroy', [ProjectsController::class, 'destroy'])->name('projects.destroy');
Route::delete('projects/{project}', [ProjectsController::class, 'destroy'])->name('projects.destroy');
Route::post('projects/filter', [ProjectsController::class, 'filter'])->name('projects.filter');


//get users 
Route::get('/users/get' , [UserController::class, 'getUsers'])->name('users.get');

//api calls 

Route::get('projects/{project}/jobs', [ProjectJobsController::class, 'index']);


Route::post('projects/{project}/update', [ProjectsController::class, 'update'])->name('projects.update');
Route::get('projects/{project}', [ProjectsController::class, 'show'])->name('projects.show');
Route::get('projects/{project}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
Route::patch('projects/{project}/status-update', [ProjectsController::class, 'statusUpdate'])->name('projects.status-update');
Route::patch('/projects/{project}/update', [ProjectsController::class, 'update']);

// Activity routes
Route::get('projects/{project}/activities', [ActivityController::class, 'index'])->name('projects.activities.index');


// Project  Jobs routes
Route::get('projects/{project}/jobs-export/{type?}', [JobsController::class, 'jobsExport'])->name('projects.jobs-export');
Route::get('projects/{project}/job-progress-export/{type?}', [JobsController::class, 'jobProgressExport'])->name('projects.job-progress-export');
Route::get('projects/{project}/jobs', [JobsController::class, 'index'])->name('projects.jobs.index');
Route::get('projects/{project}/jobs/create', [JobsController::class, 'create'])->name('projects.jobs.create');
Route::post('projects/{project}/jobs', [JobsController::class, 'store'])->name('projects.jobs.store');
Route::get('projects/{project}/jobs/add-from-other-project', [JobsController::class, 'addFromOtherProject'])->name('projects.jobs.add-from-other-project');
Route::post('projects/{project}/jobs/store-from-other-project', [JobsController::class, 'storeFromOtherProject'])->name('projects.jobs.store-from-other-project');
Route::post('projects/{project}/jobs-reorder', [JobsController::class, 'jobsReorder'])->name('projects.jobs-reorder');

// Issue routes
Route::get('projects/{project}/issues', [IssueController::class, 'index'])->name('projects.issues.index');


Route::get('projects/{project}/issues/create', [IssueController::class, 'create'])->name('projects.issues.create');
Route::post('projects/{project}/issues', [IssueController::class ,'store'])->name('projects.issues.store');
Route::get('projects/{project}/issues/{issue}', [IssueController::class ,'show'])->name('projects.issues.show');
Route::get('projects/{project}/issues/{issue}/edit',[IssueController::class ,'edit'])->name('projects.issues.edit');
Route::patch('projects/{project}/issues/{issue}', [IssueController::class ,'update'])->name('projects.issues.update');
Route::delete('projects/{project}/issues/{issue}', [IssueController::class ,'destroy'])->name('projects.issues.destroy');



// Comment routes
Route::get('projects/{project}/comments', [CommentsController::class, 'index'])->name('projects.comments.index');
// Route::get('projects/{project}/comments', [App\Http\Controllers\ProjectManagement\Jobs\CommentsController::class, 'store'])->name('projects.comments.store');
Route::patch('projects/{project}/comments/{comment}',  [CommentsController::class, 'update'])->name('projects.comments.update');
Route::delete('projects/{project}/comments/{comment}',  [CommentsController::class, 'destroy'])->name('projects.comments.destroy');
Route::post('projects/{project}/comments', [CommentsController::class ,'store'])->name('projects.comments.store');

// File routes
Route::get('projects/{project}/files', [FilesController::class, 'index'])->name('project.files');
Route::get('projects/{id}/files', [ProjectsController::class, 'files'])->name('projects.files');
Route::post('projects/{project}/files', [FilesController::class, 'create'])->name('files.upload');
Route::post('projects/{project}/files/update', [FilesController::class, 'update']);
Route::post('projects/files/{fileable}', [FilesController::class, 'create'])->name('files.upload');
Route::get('projects/files/{file}', [FilesController::class, 'show'])->name('files.download');
Route::patch('projects/files/{file}', [FilesController::class, 'update'])->name('files.update');
Route::delete('projects/files/{file}', [FilesController::class, 'destroy'])->name('files.destroy');
// Route::get('projects/{project}/files', [FilesController::class, 'index'])->name('files.edit');
 

// Subscription routes
Route::get('projects/{project}/subscriptions', [ProjectsController::class, 'subscriptions'])->name('projects.subscriptions');
Route::get('subscriptions/create', [SubscriptionsController::class, 'create'])->name('subscriptions.create');
Route::get('subscriptions', [SubscriptionsController::class, 'index'])->name('subscriptions.index');
Route::post('subscriptions/store', [SubscriptionsController::class, 'store'])->name('subscriptions.store');

    /*
     * Jobs Routes
     */
    Route::get('jobs/', [App\Http\Controllers\ProjectManagement\JobsController:: class ,'index'])->name('jobs.index');
    Route::get('jobs/{job}', [App\Http\Controllers\ProjectManagement\JobsController::class ,'show'])->name( 'jobs.show');
    Route::get('tasks/list'  , [App\Http\Controllers\ProjectManagement\JobsController::class, 'getTasksByFilter'])->name('jobs.list');


      /*
     * Job Actions Routes
     */
    Route::get('jobs/{job}/edit', [App\Http\Controllers\ProjectManagement\JobsController::class ,'edit'])->name('jobs.edit');
    Route::patch('jobs/{job}',  [App\Http\Controllers\ProjectManagement\JobsController::class ,'update'])->name('jobs.update');
    Route::get('jobs/{job}/delete', [App\Http\Controllers\ProjectManagement\JobsController::class ,'delete'])->name('jobs.delete');
    Route::delete('jobs/{job}', [App\Http\Controllers\ProjectManagement\JobsController::class ,'destroy'])->name('jobs.destroy');
    Route::post('jobs/{id}/tasks-reorder', [App\Http\Controllers\ProjectManagement\JobsController::class ,'tasksReorder'])->name('jobs.tasks-reorder');


      /*
     * Tasks Routes
     */
    Route::get('jobs/{job}/tasks/create', [TasksController::class ,'create'])->name('tasks.create');
    Route::post('jobs/{job}/tasks',  [TasksController::class ,'store'])->name('tasks.store');
    Route::patch('tasks/{task}', [TasksController::class ,'update'])->name('tasks.update');
    Route::patch('tasks/{task}/set_done', [TasksController::class ,'setDone'])->name('tasks.set_done');
    Route::delete('tasks/{task}',  [TasksController::class ,'destroy'])->name('tasks.destroy');
    Route::post('tasks/{task}/set-as-job', [TasksController::class ,'setAsJob'])->name('tasks.set-as-job');


        /*
     * Project Comments Routes
     */
    Route::get('jobs/{job}/comments', [CommentsController::class ,'index'])->name('jobs.comments.index');
    Route::post('jobs/{job}/comments', [CommentsController::class , 'store'])->name('jobs.comments.store');
    Route::patch('jobs/{job}/comments/{comment}',[CommentsController::class , 'update'])->name('jobs.comments.update');
    Route::delete('jobs/{job}/comments/{comment}', [CommentsController::class ,'destroy'])->name('jobs.comments.destroy');
    Route::post('issues/{issue}/comments', 'Issues\CommentController@store')->name('issues.comments.store');
    Route::post('issues/{issue}/comments', [IssueController::class ,'store'])->name('issues.comments.store');


    /*
 * Issue Options Routes
 */
Route::get('/issues' , [App\Http\Controllers\ProjectManagement\Issues\IssueController::class , 'index'])->name('issues.index');
Route::get('issues/{issue}', [App\Http\Controllers\ProjectManagement\Issues\IssueController::class, 'showIssue'])->name('issues.show');
Route::post('issues/', [App\Http\Controllers\ProjectManagement\Issues\IssueController::class ,'store'])->name('issues.store');
Route::patch('issues/{issue}', [App\Http\Controllers\ProjectManagement\Issues\IssueController::class ,'update'])->name('issues.update');

Route::patch('issues/{issue}/options', [OptionController::class ,'update'])->name('issues.options.update');

// Route::get('issues/', [IssuesController::class ,'index'])->name('issues.index');

// Route::resource('issues', IssueController::class);


//okr routes


        # Personal Calendar
        // Route::resource('events','EventController');
        Route::get('calendar', 'ActivityController@calendar')->name('calendar.index');
        Route::post('calendar/user/{user}/create', 'ActivityController@create')->name('calendar.create');
        Route::get('calendar/activity/{activity}/show', 'ActivityController@show')->name('calendar.show');
        Route::patch('calendar/activity/{activity}/update', 'ActivityController@update')->name('calendar.update');
        Route::delete('calendar/activity/{activity}/destroy', 'ActivityController@destroy')->name('calendar.destroy');
        // Get iCal format
        Route::get("ical-events", "IcalendarController@getEventsICalObject")->name('calendar.ical');



    # OKR
    // Delete Objective
    Route::delete('objective/{objective}/destroy', [ObjectiveController::class , 'destroy'])->name('objective.destroy');

    //view list okrs 
    Route::get('Objectives/', [OkrController::class ,'listOKR'])->name('iokr.list');
    Route::get('Objectives/all', [OkrController::class ,'getObjectives'])->name('objectives.list');

    // Edit OKR page
    Route::get('okr/{objective}/edit', [OkrController::class , 'edit'])->name('okr.edit');
    // Update the modified OKR
    Route::patch('okr/{objective}/update', [OkrController::class , 'update'])->name('okr.update');
    // Save Key Result
    Route::post('kr/store', [KrController::class , 'store'])->name('kr.store');
    // Delete Key Result
    Route::delete('kr/{keyresult}/destroy', [KrController::class , 'destroy'])->name('kr.destroy');
    // JSON API
    Route::get('objective/{objective}/getArray', [ObjectiveController::class , 'getArray'])->name('objective.getArray');



 # Action

 // show list of actions 
 Route::get('actions/models/{actionOn}', [ActionsController::class, 'getModels'])->name('actions.models');
 //fecth related action 
Route::get('/actions', [ActionsController::class , 'index'])->name('actions.index');

//get objective and priorities for creating a n Action

Route::get('/actions/get', [ActionsController::class, 'get'])->name('actions.get');
Route::get('/actions/getfiltered', [ActionsController::class, 'filterActions'])->name('actions.filter');
Route::get('/priorities/get', [ActionsController::class, 'getPriorities'])->name('priorities.get');


//get key results 
Route::get('/actions/keyresults/{id}', [ActionsController::class, 'getKeyResults'])->name('actions.keyresults');

// Create Action page
Route::get('objective/{objective}/action/create', [ActionsController::class, 'create'])->name('actions.create');
// Save Action
Route::post('actions/store', [ActionsController::class , 'store'])->name('actions.store');
Route::post('actions/storeloneaction', [ActionsController::class , 'storeloneaction'])->name('actions.storeloneaction');

// Complete Action
Route::post('actions/{action}/done', [ActionsController::class , 'done'])->name('actions.done');
// Edit Action page
Route::get('actions/{action}/edit', [ActionsController::class , 'edit'])->name('actions.edit');
// Update Action
Route::patch('actions/{action}/update', [ActionsController::class, 'update'])->name('actions.update');

Route::patch('actions/{action}/updateloneaction', [ActionsController::class , 'updateloneaction'])->name('actions.updateloneaction');

// Show specified Action
Route::get('actions/{action}/show', [ActionsController::class , 'show'])->where('action', '[0-9]+')->name('actions.show');
Route::get('actions/{action}/showloneaction', [ActionsController::class , 'showloneaction'])->where('action', '[0-9]+')->name('actions.showloneaction');


// Delete personal Action
Route::delete('actions/{action}/destroy', [ActionsController::class ,'destroy'])->name('actions.destroy');
Route::delete('actions/{action}/destroyloneaction', [ActionsController::class ,'destroyloneAction'])->name('actions.destroyloneAction');
// Delete Action's file
Route::get('actions/{action}/media/{media}/destroy', [ActionsController::class , 'destroyFile'])->name('actions.destroyFile');
// Return search
Route::get('objective/{objective}/action/user/search', [ActionsController::class , 'search'])->name('actions.user.search');
// Reject invitation
Route::get('actions/{action}/member/{member}/invite/reject', [ActionsController::class ,' rejectInvite'])->name('actions.member.invite.reject');
// Agree to invitation
Route::get('actions/{action}/member/{member}/invite/agree', [ActionsController::class , 'agreeInvite'])->name('actions.member.invite.agree');


# Organization OKR
// Organization OKR homepage
Route::get('organization', [CompanyController::class , 'index'])->name('company.index');

//get a list of all available organizations 

Route::get('organization/lists', [OrganizationController::class, 'get'])->name('organization.get');

// Add company
Route::post('organization/company/store', [CompanyController::class , 'store'])->name('company.store');
// Edit company page
Route::get('organization/company/edit', [CompanyController::class , 'edit'])->name('company.edit');
// Update company
Route::patch('organization/company/update', [CompanyController::class , 'update'])->name('company.update');
// Delete company
Route::delete('organization/company/destroy', [CompanyController::class , 'destroy'])->name('company.destroy');
// Show company OKR
Route::get('organization/company/okr', [CompanyController::class , 'listOKR'])->name('company.okr');
// Add company Objective
Route::post('organization/company/{company}/objective/store', [CompanyController::class , 'storeObjective'])->name('company.objective.store');
// Company members page
Route::get('organization/company/member', [CompanyController::class , 'member'])->name('company.member');
// Send invite
Route::post('organization/company/{company}/member/invite', [CompanyController::class , 'inviteMember'])->name('company.member.invite');
// Cancel invite
Route::patch('organization/company/{company}/member/{member}/invite/destroy', [CompanyController::class , 'cancelInvite'])->name('company.member.invite.destroy');
// Reject invite
Route::get('organization/company/{company}/member/{member}/invite/reject', [CompanyController::class , 'rejectInvite'])->name('company.member.invite.reject');
// Agree to invite
Route::get('organization/company/{company}/member/{member}/invite/agree', [CompanyController::class , 'agreeInvite'])->name('company.member.invite.agree');
// Update company members
Route::patch('organization/company/member/update', [CompanyController::class , 'updateMember'])->name('company.member.update');
// Delete company members
Route::patch('organization/company/member/{member}/destroy', [CompanyController::class , 'destroyMember'])->name('company.member.destroy');
// Change company admin
Route::patch('organization/company/admin/change', [CompanyController::class , 'changeAdmin'])->name('company.admin.change');
// Delete company admin
Route::patch('organization/company/admin/delete', [CompanyController::class , 'deleteAdmin'] )->name('company.admin.delete');
// Import users
Route::get('organization/company/admin/import', [CompanyController::class , 'importUser'])->name('company.import.user');
// Handle bulk import of users
Route::post('organization/company/admin/import', [CompanyController::class , 'handleImportUser'])->name('company.bulk.import.user');

// Show sub-department page
Route::get('organization/department/{department}', 'DepartmentController@index')->name('department.index');
// Save new department
Route::post('organization/department/store', 'DepartmentController@store')->name('department.store');
// Edit department page
Route::get('organization/department/{department}/edit', 'DepartmentController@edit')->name('department.edit');
// Update department
Route::patch('organization/department/{department}/update', 'DepartmentController@update')->name('department.update');
// Delete department
Route::delete('organization/department/{department}/destroy', 'DepartmentController@destroy')->name('department.destroy');
// Show department OKR
Route::get('organization/department/{department}/okr', 'DepartmentController@listOKR')->name('department.okr');
// Add department Objective
Route::post('organization/department/{department}/objective/store', 'DepartmentController@storeObjective')->name('department.objective.store');
// Department members page
Route::get('organization/department/{department}/member', 'DepartmentController@member')->name('department.member');
// Department members settings page
Route::get('organization/department/{department}/member/setting', 'DepartmentController@memberSetting')->name('department.member.setting');
// Add department member
Route::post('organization/department/{department}/member/store', 'DepartmentController@storeMember')->name('department.member.store');
// Update department member
Route::patch('organization/department/{department}/member/{member}/update', 'DepartmentController@updateMember')->name('department.member.update');
// Delete department member
Route::patch('organization/department/{department}/member/{member}/destroy', 'DepartmentController@destroyMember')->name('department.member.destroy');


Route::get('user/{user}/okr', 'UserController@listOKR')->name('user.okr');

   // 顯示個人Action
   Route::get('user/{user}/action', 'UserController@listAction')->name('user.action');
   // 顯示個人帳號設定
   Route::get('user/{user}', 'UserController@settings')->name('user.settings');
   // 更新個人照片
   Route::patch('user/{user}/update', 'UserController@update')->name('user.update');
   // 新增個人O
   Route::post('user/{user}/objective/store', 'UserController@storeObjective')->name('user.objective.store');
   //變更密碼
   Route::post('user/resetPassword','UserController@resetPassword')->name('user.resetPassword');
    # 追蹤
    //專案首頁
    Route::get('follow', [FollowController::class , 'index'])->name('follow.index');
    //追蹤
    Route::get('follow/{type}/{owner}', [FollowController::class , 'follow'])->name('follow');
    //取消追蹤
    Route::get('follow/{type}/{owner}/cancel', [FollowController::class ,'cancel'])->name('follow.cancel');


    //tickets route
    Route::get('add-new-ticket', [TicketsController::class, 'create'])->name('submit-new-ticket.create');
    Route::post('new-ticket-store', [TicketsController::class, 'store'])->name('new-ticket-store.store');
    Route::get('ticket/{ticket_id}', [TicketsController::class, 'show'])->name('ticket.show');
    Route::get('tickets', [TicketsController::class, 'index'])->name('tickets.index');
    Route::get('opened-tickets', [TicketsController::class, 'openedTickets'])->name('opened-tickets.openedTickets');
    Route::get('closed-tickets', [TicketsController::class, 'ClosedTickets'])->name('closed-tickets.ClosedTickets');
    Route::post('close_ticket/{ticket_id}', [TicketsController::class, 'close'])->name('close_ticket.close');
    Route::post('reopen/{ticket_id}', [TicketsController::class, 'reOpen'])->name('ticketReOpen');
    Route::get('notifications', [NotificationController::class, 'allNotification'])->name('allNotification');
    //ticket data
    Route::get('get-ticket-data', [TicketsController::class, 'getTicketData'])->name('getTicketData');
    Route::get('ticket-assign-to/{id}', [TicketsController::class, 'assignTo'])->name('assignTo');
    Route::post('ticket-assigned/{id}', [TicketsController::class, 'assignToDepartment'])->name('assignToDepartment');

    //department route
    Route::get('/departments', [DepartmentsController::class, 'index'])->name('departments.index');
    Route::get('get-departments-data', [DepartmentsController::class, 'getDepartmentData'])->name('getDepartmentData');
    Route::get('/department-create', [DepartmentsController::class, 'create'])->name('department-create.create');
    Route::get('/department/{id}/edit', [DepartmentsController::class, 'edit'])->name('department-edit');
  
    Route::get('department', [DepartmentsController::class, 'index'])->name('department.index');
    Route::get('department/{id}', [DepartmentsController::class, 'departmentTickets'])->name('departmentTickets');
  
    Route::post('department-save', [DepartmentsController::class, 'store'])->name('department-save.store');
    Route::get('department-edit/{id}', [DepartmentsController::class, 'edit'])->name('department-edit.edit');
    Route::post('department-update/{id}', [DepartmentsController::class, 'update'])->name('department-update.update');
    Route::delete('department-delete/{id}', [DepartmentsController::class, 'destroy'])->name('department-delete.destroy');

    Route::get('/knowledge', [KnowledgeBaseController::class, 'KnowledgeBaseIndex'])->name('KnowledgeBaseIndex');
    Route::get('contact-us', [ContactController::class,'index'])->name('contactPage');
    Route::post('contact-store', [ContactController::class,'store'])->name('contactStore');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');