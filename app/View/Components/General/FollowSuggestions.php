<?php

namespace App\View\Components\General;

use Illuminate\View\Component;
use App\Models\Profile;

class FollowSuggestions extends Component
{
    public $profiles;
    /**
    * Create a new component instance.
    *
    * @return void
    */
    public function __construct(Profile $profile) {
        $this->profiles = Profile::whereNotIn('id', $this->profile->following->pluck('id'))->get();
    }

    /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
    public function render() {
        return view('components.general.follow-suggestions');
    }
}