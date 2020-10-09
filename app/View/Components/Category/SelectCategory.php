<?php

namespace App\View\Components\Category;

use App\Models\Category;
use Illuminate\View\Component;

class SelectCategory extends Component
{
    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->categories = Category::without('products')->orderBy('title', 'ASC')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.category.select-category');
    }
}
