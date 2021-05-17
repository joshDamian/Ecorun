<?php

namespace App\Providers;

use App\Models\Build\Business\Business;
use App\Models\Connect\Conversation\DirectConversation;
use App\Models\Build\Sellable\Product\Product;
use App\Models\Connect\Profile\Profile;
use App\Models\Information\Basic\Contact;
use App\Models\Team;
use App\Policies\ContactPolicy;
use App\Policies\DirectConversationPolicy;
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
        ProfilePolicy::class => Profile::class,
        DirectConversation::class => DirectConversationPolicy::class,
        Contact::class => ContactPolicy::class
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
                return $user->associated_profiles->all->pluck('profileable')->count() > 0;
            }
        );
    }
}
