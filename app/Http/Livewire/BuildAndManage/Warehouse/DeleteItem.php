<?php

namespace App\Http\Livewire\BuildAndManage\Warehouse;

use Livewire\Component;

class DeleteItem extends Component
{
    public $item;
    public $confirm;

    public function delete()
    {
        $business = $this->item->vendor;
        $this->item->delete();
        redirect()->to($business->url->warehouse);
    }

    public function confirmDeleteSellable()
    {
        $this->confirm = true;
    }

    public function render()
    {
        return view('livewire.build-and-manage.warehouse.delete-item');
    }
}
