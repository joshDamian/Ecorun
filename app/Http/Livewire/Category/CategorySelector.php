<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Livewire\Component;

class CategorySelector extends Component
{
    public $categories;

    public $activeCategory;

    public function mount() 
    {
        $this->categories = Category::without('products')->orderBy('title', 'ASC')->get();
        $this->activeCategory = $this->categories->first()->title;
    } 

    public function render()
    {
        return view('livewire.category.category-selector');
    }
}
