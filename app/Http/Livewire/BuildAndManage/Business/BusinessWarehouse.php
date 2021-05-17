<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Build\Business\Business;
use Livewire\Component;
use Livewire\WithPagination;

class BusinessWarehouse extends Component
{
    use WithPagination;

    public Business $business;
    public $active_item;
    protected $listeners = [
        'viewAll'
    ];

    public function mount($active_item = null)
    {
        return ($active_item) ?  $this->switchActiveItem($active_item) : true;
    }

    public function switchActiveItem($item)
    {
        $item = $this->business->warehouse()->withoutGlobalScopes()->find($item);
        return $this->active_item = $item;
    }

    public function viewAll()
    {
        $this->active_item = null;
    }

    public function render()
    {
        $warehouse = $this->business->warehouse()->withoutGlobalScopes()->latest()->paginate(12);
        $components = [
            'product' => [
                'component' => 'build-and-manage.product.product-dashboard'
            ],
            'service' => [
                'component' => 'build-and-manage.service.service-dashboard'
            ]
        ];
        return view('livewire.build-and-manage.business.business-warehouse', compact('warehouse', 'components'));
    }
}
