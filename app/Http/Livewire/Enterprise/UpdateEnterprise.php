<?php

namespace App\Http\Livewire\Enterprise;

use App\Models\Enterprise;
use Livewire\Component;

class UpdateEnterprise extends Component
{
    public Enterprise $enterprise;
    
    public function render()
    {
        return view('livewire.enterprise.update-enterprise');
    }
}
