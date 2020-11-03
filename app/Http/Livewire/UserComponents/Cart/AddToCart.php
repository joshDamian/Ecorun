<?php

namespace App\Http\Livewire\UserComponents\Cart;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class AddToCart extends Component
{
    public $product;
    public $add_specs;
    public $specifications = [];
    public $quantity;
    protected $listeners = [
        'modifiedCart' => '$refresh'
    ];


    protected $rules = [
        'quantity' => ['required', 'min:1', 'int']
    ];

    public function mount(Product $product)
    {
        $this->product = $product;

        $indicated_specs = $this->product->indicatedSpecs();
        if ($indicated_specs->count() > 0) {
            foreach ($indicated_specs as $spec) {
                $this->specifications[Str::singular($spec->name)] = null;
            }
        }
    }

    public function request_data()
    {
        $this->add_specs = true;
    }

    public function add_prod()
    {
        $this->validate();
        if (!$this->existing()) {
            (Auth::user()) ?
                $this->product->cart_instances()->save(
                    Auth::user()->cart()->create(
                        [
                            'quantity' => $this->quantity
                        ]
                    )
                ) :
                session()->put(
                    "guest_cart.{$this->product->id}",
                    [
                        'product_id' => $this->product->id,
                        'quantity' => $this->quantity
                    ]
                );

            $this->emit('modifiedCart');
        }
    }

    public function messages()
    {
        return [
            'specifications.*.required' => 'This value is required'
        ];
    }

    public function add_specs_prod()
    {
        $this->validate(
            [
                'quantity' => ['required', 'min:1', 'int'],
                'specifications.*' => ['required']
            ]
        );

        if (!$this->existing()) {
            (Auth::user()) ?
                $this->product->cart_instances()->save(
                    Auth::user()->cart()->create(
                        [
                            'quantity' => $this->quantity,
                            'specifications' => $this->specifications
                        ]
                    )
                ) :
                session()->put(
                    "guest_cart.{$this->product->id}",
                    [
                        'product_id' => $this->product->id,
                        'quantity' => $this->quantity,
                        'specifications' => $this->specifications
                    ]
                );

            $this->emit('modifiedCart');
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function existing()
    {
        if (Auth::user()) {
            $existing = (Auth::user()->cart()->whereIn('product_id', [$this->product->id])->count() > 0);
        } else {
            (session()->get('guest_cart')) ? true : session()->put('guest_cart', []);
            $guest_cart = session()->get('guest_cart');
            $existing = array_key_exists($this->product->id, $guest_cart);
        }
        return $existing;
    }

    public function render()
    {
        return view('livewire.user-components.cart.add-to-cart');
    }
}
