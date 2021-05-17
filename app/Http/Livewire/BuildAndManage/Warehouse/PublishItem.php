<?php

namespace App\Http\Livewire\BuildAndManage\Warehouse;

use Livewire\Component;

class PublishItem extends Component
{
    public $item;

    public function publish()
    {
        if ($this->item->sellable->gallery->count() < 1) {
            $this->emitSelf('publishingError');
            return $this->addError('publishing', 'you cannot publish an item with no images');
        }
        $this->item->is_published = true;
        return $this->item->save();
    }

    public function unpublish()
    {
        $this->item->is_published = false;
        $this->item->save();
    }

    public function render()
    {
        return view('livewire.build-and-manage.warehouse.publish-item');
    }
}
