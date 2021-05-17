<?php

namespace App\Http\Livewire\Connect\Contact;

use App\Models\Information\Basic\Contact;
use Livewire\Component;

class EditContact extends Component
{
    public Contact $contact;

    public function update()
    {
        $this->validate();
        $this->contact->save();
        $this->emitSelf('saved');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function rules()
    {
        return [
            'contact.phone' => ['required', 'digits_between:10,11'],
        ];
    }

    public function render()
    {
        return view('livewire.connect.contact.edit-contact');
    }
}
