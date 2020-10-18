<?php

namespace App\Http\Livewire\UserComponents\Product;

use App\Models\Product;
use App\Models\Service;
use Livewire\Component;

class ServiceProductList extends Component
{
    public function render()
    {
        $services = Service::all();
        $services_enterprise_id = [];

        foreach ($services as $service) {
            array_push($services_enterprise_id, $service->enterprise->id);
        }

        return view('livewire.user-components.product.service-product-list', [
            'service_products' => Product::whereIn('enterprise_id', $services_enterprise_id)->where('is_published', true)->latest()->paginate(10)
        ]);
    }
}
