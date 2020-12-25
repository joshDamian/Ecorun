<?php

namespace App\View\Components\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class CategoryListing extends Component
{
    public $categories;
    public $iterable_titles = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = Category::without('products')->where('parent_title', null)->get();
        $titles = $this->categories->pluck('title');

        foreach ($titles as $title) {
            $this->iterable_titles[$title] = Str::of($title)->snake();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.category.category-listing');
    }
}
