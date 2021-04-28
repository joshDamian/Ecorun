<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Build\Business\Business;
use Livewire\Component;

class SetupBusiness extends Component
{
    public Business $business;
    public $type;

    public function render()
    {
        return view('livewire.build-and-manage.business.setup-business');
    }
}
