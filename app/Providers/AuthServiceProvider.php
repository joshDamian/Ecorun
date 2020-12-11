<?php

namespace App\Providers;

use App\Models\Business;
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

        Gate::define('own-businesses', function ($user) {
            return $user->isManager !== null;
        });

        Gate::define('update-business', function ($user, $business) {
            $user->switchProfile(Business::findOrFail($business)->profile);

            if ($user->isManager === null) {
                return false;
            } else {
                return $user->isManager->id === Business::findOrFail($business)->manager_id;
            }
        });

        Gate::define(
            'manage-business',
            function ($user, Business $business) {
                return $business->profile !== null;
            }
        );

        Gate::define(
            'reference-businesses',
            function ($user) {
                return $user->isManager->businesses->count() > 0;
            }
        );
    }
}
