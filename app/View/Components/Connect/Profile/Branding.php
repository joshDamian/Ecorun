<?php

declare(strict_types=1);

namespace App\View\Components\Connect\Profile;

use App\Models\Business;
use App\Models\Profile;
use App\Models\User;
use Illuminate\View\Component;
use App\Models\Badge;
use Illuminate\Support\Collection;

class Branding extends Component
{
    public Collection $brands;
    public Profile $profile;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Profile $profile)
    {
        $badges = Badge::all()->groupBy('canuse');
        /* dd($badges); */
        $this->profile = $profile;
        $this->brands = (match ($this->profile?->profileable_type) {
            User::class => $badges['user'],
            Business::class => $badges['business'],
            null => collect([])
        })->sort();
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
