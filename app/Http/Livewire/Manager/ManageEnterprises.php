<?php

namespace App\Http\Livewire\Manager;

use Livewire\Component;

class ManageEnterprises extends Component
{
    public $listShow;
    public $enterpriseShow;
    protected $listeners = [
        'displayEnterpriseDashboard'
    ];

    public function displayEnterpriseDashboard()
    {
        $this->listShow = null;
        $this->enterpriseShow = true;
    }

    public function mount()
    {
        $this->listShow = true;
    }

    public function render()
    {
        return view('livewire.manager.manage-enterprises');
    }
}
