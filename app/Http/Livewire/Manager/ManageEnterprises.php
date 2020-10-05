<?php

namespace App\Http\Livewire\Manager;

use Livewire\Component;

class ManageEnterprises extends Component
{
    public $listShow;
    protected $listeners = [
        'displayReady'
    ];

    public function displayReady() {
        $this->listShow = null;
    }

    public function mount() {
        $this->listShow = true;
    }

    public function render() {
        return view('livewire.manager.manage-enterprises');
    }
}