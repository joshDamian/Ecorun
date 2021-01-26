<?php

namespace App\Http\Livewire\Connect\Product;

use App\Http\Livewire\Traits\HasLikes;
use App\Http\Livewire\Traits\HasShares;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductFeedback extends Component
{
    use HasShares;
    use HasLikes;

    public $product;

    public function mount()
    {
        $this->feedback_id = random_int(1, 918000982092) . $this->product->id;
        if (Auth::check()) {
            $this->profile = Auth::user()->currentProfile;
        }
        $this->shareable = $this->likeable = $this->product;
    }

    public function getListeners()
    {
        return [
            "newLike.{$this->feedback_id}." . str_replace('\\', '.', get_class($this->product)) => 'likes',
            "newShare.{$this->feedback_id}." . str_replace('\\', '.', get_class($this->product)) => 'shares'
        ];
    }

    public function render()
    {
        return view('livewire.connect.product.product-feedback');
    }
}
