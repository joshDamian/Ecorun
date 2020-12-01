<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Business;
use Livewire\Component;

class UpdateBusiness extends Component
{
    public Business $business;
    
    public function render()
    {
        return view('livewire.build-and-manage.business.update-business');
    }
}
