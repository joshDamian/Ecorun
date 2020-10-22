<?php

namespace App\View\Components\Category;

use Illuminate\View\Component;
use App\Models\Category;

class CategoryProducts extends Component
{
    public $category;
    public $pagination;
    public $products;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($category, $pagination = null)
    {
        $this->category = Category::find($category);
        $this->pagination = $pagination;

        if ($this->pagination) {
            $this->products = $this->category->products()->where('is_published', true)->latest()->paginate(12);
        } else {
            $this->products = $this->category->products()->where('is_published', true)->latest()->get()->take(6);
        }
    }

    /** 
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.category.category-products');
    }
}
