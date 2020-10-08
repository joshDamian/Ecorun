<?php

namespace App\Http\Livewire\Store;

use App\Models\Store;
use Livewire\Component;

class UpdateStore extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.store.update-store');
    }
}
