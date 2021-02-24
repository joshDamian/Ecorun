<?php

namespace App\Http\Livewire\Buy\Cart;

use Livewire\Component;

class ManageAuthCart extends Component
{
    public $confirmDelete;
    public $itemToDelete;
    public $itemToEdit;
    protected $listeners = [
        'refreshCartDisplay' => '$refresh',
        'cancelEdit'
    ];

    public function getCartItemsProperty()
    {
        return auth()->user()->cart()->with('product.gallery', 'product.specifications')->latest('updated_at')->get();
    }

    public function triggerEdit($item)
    {
        $this->itemToEdit = $this->cartItems->find($item);
        return;
    }

    public function triggerDelete($item)
    {
        $this->itemToDelete = $this->cartItems->find($item);
        return $this->confirmDelete = true;
    }

    public function delete()
    {
        $this->itemToDelete->delete();
        $this->emitSelf('refreshCartDisplay');
        $this->emit('modifiedCart');
        return $this->cancelDelete();
    }

    public function cancelDelete()
    {
        return $this->reset('confirmDelete', 'itemToDelete');
    }

    public function cancelEdit()
    {
        return $this->reset('itemToEdit');
    }

    public function render()
    {
        return view('livewire.buy.cart.manage-auth-cart', [
            'cartItems' => $this->cartItems
        ]);
    }
}
