<?php

namespace App\Http\Livewire\Buy\Cart;

use Livewire\Component;

class ManageGuestCart extends Component
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
        return collect(session()->get('guest_cart', []))->sortByDesc('updated_at');
    }

    public function triggerDelete($item)
    {
        $this->itemToDelete = $item;
        return $this->confirmDelete = true;
    }

    public function cancelEdit()
    {
        return $this->reset('itemToEdit');
    }

    public function triggerEdit($item)
    {
        $this->itemToEdit = $item;
        return;
    }

    public function delete()
    {
        session()->forget("guest_cart.{$this->itemToDelete}");
        $this->emitSelf('refreshCartDisplay');
        $this->emit('modifiedCart');
        return $this->cancelDelete();
    }

    public function mount()
    {
        //session()->flush();
    }

    public function cancelDelete()
    {
        return $this->reset('confirmDelete', 'itemToDelete');
    }

    public function render()
    {
        return view('livewire.buy.cart.manage-guest-cart', [
            'cartItems' => $this->cartItems
        ]);
    }
}
