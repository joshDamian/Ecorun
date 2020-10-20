<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class LandingPage extends Component
{
    public $categories;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = Category::without('products')->where('parent_title', null)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.landing-page');
    }
}
