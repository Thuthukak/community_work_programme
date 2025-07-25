<?php

namespace App\Providers;

use App\Models\CRM\Deal\Deal;
use App\Models\CRM\Discussion\Discussion;
use App\Observers\DealObserver;
use App\Observers\DiscussionObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

/**
 * Class EventServiceProvider.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\NewNotification' => [
            'App\Listeners\NewNotificationListeners'],

            'App\Events\Projects\Created' => [
                'App\Listeners\Projects\LogProjectCreationActivity',
            ],
            
            'App\Events\Projects\Updated' => [
                'App\Listeners\Projects\LogProjectUpdateActivity',
            ],
            'App\Events\Jobs\Created'     => [
                'App\Listeners\Jobs\LogJobCreationActivity',
            ],
            'App\Events\Jobs\Updated'     => [
                'App\Listeners\Jobs\LogJobUpdateActivity',
            ],
            'App\Events\Jobs\Deleted'     => [
                'App\Listeners\Projects\LogProjectJobDeletionActivity',
            ],
            'App\Events\Tasks\Created'    => [
                'App\Listeners\Tasks\LogTaskCreationActivity',
            ],
            'App\Events\Tasks\Updated'    => [
                'App\Listeners\Tasks\LogTaskUpdateActivity',
            ],
            'App\Events\Tasks\Deleted'    => [
                'App\Listeners\Jobs\LogJobTaskDeletionActivity',
            ],
    ];

    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();

        Deal::observe(DealObserver::class);
        Discussion::observe(DiscussionObserver::class);
        //
        Event::listen('revisionable.*', function ($model, $revisions) {
            // Do something with the revisions or the changed model.
        // logger($model, $revisions);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
