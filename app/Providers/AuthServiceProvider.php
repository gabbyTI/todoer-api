<?php

namespace App\Providers;

use App\Models\Invitation;
use App\Models\Project;
use App\Models\SubTask;
use App\Models\Task;
use App\Policies\InvitationPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\SubTaskPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Task::class => TaskPolicy::class,
        SubTask::class => SubTaskPolicy::class,
        Project::class => ProjectPolicy::class,
        Invitation::class => InvitationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
