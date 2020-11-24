<?php

namespace App\Providers;

use App\Models\Enterprise;
use App\Models\Product;
use App\Models\Team;
use App\Policies\ProductPolicy;
use App\Policies\ProfilePolicy;
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
        Product::class => ProductPolicy::class,
        ProfilePolicy::class => Profile::class
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
            if ($user->isManager === null) {
                return false;
            } else {
                return $user->isManager->id === Enterprise::find($enterprise)->manager_id;
            }
        });

        Gate::define('manage-enterprise', function ($user, Enterprise $enterprise) {
            return $enterprise->profile !== null;
        });

        Gate::define('reference-enterprise', function ($user) {
            return $user->isManager->enterprises->count() > 0;
        });
    }
}
