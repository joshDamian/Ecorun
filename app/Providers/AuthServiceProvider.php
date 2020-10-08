<?php

namespace App\Providers;

use App\Models\Enterprise;
use App\Models\Team;
use App\Policies\TeamPolicy;
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
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('own-enterprise', function ($user) {
            return $user->isManager !== null;
        });

        Gate::define('update-enterprise', function ($user, $enterprise) {
            return $user->isManager->id === $enterprise->manager_id;
        });

        Gate::define('manage-enterprise', function ($user, $enterprise) {
            return $enterprise->enterpriseable !== null;
        });

        Gate::define('reference-enterprise', function ($user) {
            return $user->isManager->enterprises->count() > 0;
        });
    }
}
