<?php

namespace App\Http\Livewire\Buy\LandingPage;

use App\Models\Product;
use App\Models\Service;
use Livewire\Component;

class FeaturedServiceProducts extends Component
{
    public function render()
    {
        $services = Service::all();
        $services_enterprise_id = [];

        foreach ($services as $service) {
            array_push($services_enterprise_id, $service->enterprise->id);
        }

        return view('livewire.buy.landing-page.featured-service-products', [
            'service_products' => Product::whereIn('enterprise_id', $services_enterprise_id)->where('is_published', true)->latest()->paginate(10)
        ]);
    }
}
