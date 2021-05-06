<?php

namespace App\Http\Livewire\BuildAndManage\Business\Sell;

use App\Models\Build\Business\Business;
use Livewire\Component;

class Sell extends Component
{
    public Business $business;
    public $sellType;

    public function select(string $sellType)
    {
        $this->sellType = $sellType;
        return;
    }

    public function mount(?string $sellType = null)
    {
        if (is_string($sellType) && in_array($sellType, ['product', 'service'])) {
            $this->sellType = $sellType;
        }
    }

    public function clear()
    {
        $this->sellType = null;
        return;
    }

    public function render()
    {
        $components = [
            'product' => 'build-and-manage.product.create-new-product',
            'service' => 'build-and-manage.service.create-new-service'
        ];
        return view('livewire.build-and-manage.business.sell.sell', compact('components'));
    }
}
