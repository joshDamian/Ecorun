<?php

declare(strict_types=1);

namespace App\View\Components\Connect\Profile;

use App\Models\Business;
use App\Models\Profile;
use App\Models\User;
use Illuminate\View\Component;

class Branding extends Component
{
    public array $brands;
    public Profile $profile;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
        $this->brands = collect((match ($this->profile?->profileable_type) {
            User::class => config('branding.brands.user-profiles'),
            Business::class => config('branding.brands.business-profiles'),
            null => []
        }))->sort()->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.connect.profile.branding');
    }
}
