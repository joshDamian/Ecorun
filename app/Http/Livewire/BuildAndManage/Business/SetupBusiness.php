<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Enterprise;
use Livewire\Component;

class SetupBusiness extends Component
{
    public Enterprise $enterprise;
    public $type;

    public function render()
    {
        return view('livewire.build-and-manage.business.setup-business');
    }
}
