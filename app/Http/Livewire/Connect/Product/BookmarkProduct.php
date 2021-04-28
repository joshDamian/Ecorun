<?php

namespace App\Http\Livewire\Connect\Product;

use Livewire\Component;
use App\Models\Build\Sellable\Product\Product;
use App\Http\Livewire\Traits\HasBookmarks;
use Illuminate\Support\Facades\Auth;

class BookmarkProduct extends Component
{
    use HasBookmarks;

    public Product $product;

    public function mount()
    {
        $this->bookmarkable = $this->product;
        if (Auth::check()) {
            $this->profile = Auth::user()->currentProfile;
            $this->bookmarked = $this->bookmarked();
        }
    }

    public function render()
    {
        return view('livewire.connect.product.bookmark-product');
    }
}
