<?php

namespace App\Http\Livewire\Enterprise;

use App\Models\Enterprise;
use Livewire\Component;

class SetupEnterprise extends Component
{
    public Enterprise $enterprise;
    public $type;

    public function render()
    {
        return view('livewire.enterprise.setup-enterprise');
    }
}
