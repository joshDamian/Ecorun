<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Build\Business\Business;
use App\Models\Build\Sellable\Product\Product;
use App\Models\Build\Sellable\Sellable;
use App\Models\Buy\Service\Service;
use App\Scopes\ProductAccessibleScope;
use App\Scopes\ProductViewableScope;
use Livewire\Component;
use Livewire\WithPagination;

class BusinessWarehouse extends Component
{
    use WithPagination;

    public Business $business;
    public $active_sellable;
    protected $listeners = [
        'viewAll'
    ];

    public function mount($active_sellable = null)
    {
        return ($active_sellable) ?  $this->switchActiveItem($active_sellable) : true;
    }

    public function switchActiveProduct(Sellable $sellable)
    {
        return $this->active_sellable = $sellable;
    }

    public function viewAll()
    {
        $this->active_sellable = null;
    }

    public function render()
    {
        $warehouse = $this->business->warehouse()->latest()->paginate(12);
        $components = [
            Product::class => [
                'model_name' => 'product',
                'component' => 'build-and-manage.product.product-dashboard'
            ],
            Service::class => [
                'model_name' => 'service',
                'component' => 'build-and-manage.service.service-dashboard'
            ]
        ];
        return view('livewire.build-and-manage.business.business-warehouse', compact('warehouse', 'components'));
    }
}
