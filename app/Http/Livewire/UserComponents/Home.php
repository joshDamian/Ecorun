<?php

namespace App\Http\Livewire\UserComponents;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        //session()->flush();
        return view('livewire.user-components.home');
    }
}
