<?php

namespace App\Providers;

use App\Models\Business;
use App\Models\Product;
use App\Models\Profile;
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

        Gate::define(
            'reference-businesses',
            function ($user) {
                return $user->associatedProfiles()->loadMissing('profileable')->pluck('profileable')->count() > 0;
            }
        );
    }
}
