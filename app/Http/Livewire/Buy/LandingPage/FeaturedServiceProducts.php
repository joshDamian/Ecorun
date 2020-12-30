<?php

namespace App\Http\Livewire\Buy\LandingPage;

use App\Models\Product;
use App\Models\Service;
use Livewire\Component;

class FeaturedServiceProducts extends Component
{
    public function render()
    {
        $services = Service::all()->pluck('business.id');

        return view('livewire.buy.landing-page.featured-service-products', [
            'service_products' => Product::whereIn('business_id', $services)->where('is_published', true)->latest()->paginate(10)
        ]);
    }
}
