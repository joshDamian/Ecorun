<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use App\Models\Profile;

class NavContent extends Component
{
    public $user;
    public $profile_tag_suffix;

    /**
    * Create a new component instance.
    *
    * @return void
    */
    public function __construct() {
        $this->user = Auth::user();
        $this->profile_tag_suffix = Profile::TAG_SUFFIX;
    }

    /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
    public function render() {
        return view('components.nav-content');
    }
}