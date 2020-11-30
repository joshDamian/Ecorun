<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BusinessProductList extends Component
{
    use WithPagination;

    public $enterprise;
    public $active_product;

    protected $listeners = [
        'viewAll'
    ];

    public function switchActiveProduct(Product $product)
    {
        $this->active_product = $product;
    }

    public function viewAll()
    {
        $this->active_product = null;
    }

    public function render()
    {
        return view('livewire.build-and-manage.business.business-product-list', [
            'products' => Auth::user()->isManager->enterprises->find($this->enterprise)->products()->latest()->paginate(12)
        ]);
    }
}
