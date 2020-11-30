<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Enterprise;
use Livewire\Component;

class UpdateBusiness extends Component
{
    public Enterprise $enterprise;
    
    public function render()
    {
        return view('livewire.build-and-manage.business.update-business');
    }
}
