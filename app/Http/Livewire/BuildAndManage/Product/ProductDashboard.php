<?php

namespace App\Http\Livewire\BuildAndManage\Product;

use Livewire\Component;

class ProductDashboard extends Component
{
    public $item;
    protected $listeners = [
        'unpublishedMe' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.build-and-manage.product.product-dashboard', [
            'product' => $this->item->sellable
        ]);
    }
}
