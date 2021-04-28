<?php

namespace App\Http\Livewire\BuildAndManage\Business\Sell;

use App\Models\Build\Business\Business;
use Livewire\Component;

class Sell extends Component
{
    public Business $business;
    public array $components = [
        'product/consumable' => 'build-and-manage.product.create-new-product'
    ];
    public $sellType;

    public function select(string $sellType)
    {
        $this->sellType = $sellType;
        return;
    }

    public function clear()
    {
        $this->sellType = null;
        return;
    }

    public function render()
    {
        return view('livewire.build-and-manage.business.sell.sell');
    }
}
