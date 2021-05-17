<?php

namespace App\Http\Livewire\Connect\Sellable;

use Livewire\Component;
use App\Http\Livewire\Traits\HasBookmarks;
use App\Models\Build\Sellable\Product\Product;
use App\Models\Buy\Service\Service;
use Illuminate\Support\Facades\Auth;

class BookmarkSellable extends Component
{
    use HasBookmarks;

    public Product|Service $sellable;

    public function mount()
    {
        $this->bookmarkable = $this->sellable;
        if (Auth::check()) {
            $this->profile = Auth::user()->currentProfile;
            $this->bookmarked = $this->bookmarked();
        }
    }

    public function render()
    {
        return view('livewire.connect.sellable.bookmark-sellable');
    }
}
