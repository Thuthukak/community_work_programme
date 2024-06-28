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
use App\Models\Core\Auth\User;
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
    return redirect('admin/users/login');
});

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

Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
Route::get('projects/create', [ProjectsController::class, 'create'])->name('projects.create');
Route::get('projects/{project}/delete', [ProjectsController::class, 'delete'])->name('projects.delete');
Route::get('projects/destroy', [ProjectsController::class, 'destroy'])->name('projects.destroy');
Route::delete('projects/{project}', [ProjectsController::class, 'destroy'])->name('projects.destroy');


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
    Route::delete('jobs/{job}/comments/{comment}', [CommentsController::class ,'destroy'])->name('jobs.comments.destroy');Route::post('issues/{issue}/comments', 'Issues\CommentController@store')->name('issues.comments.store');
    Route::post('issues/{issue}/comments', [IssueController::class ,'store'])->name('issues.comments.store');


    /*
 * Issue Options Routes
 */
Route::patch('issues/{issue}/options', [OptionController::class ,'update'])->name('issues.options.update');

// Route::get('issues/', [IssuesController::class ,'index'])->name('issues.index');

Route::resource('issues', IssueController::class);
