<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SearchRequestReceptor extends Component
{
    public $query;

    public function updated()
    {
        $this->emit('search', $this->query);
    }

    public function render()
    {
        return view('livewire.search-request-receptor');
    }
}
