<?php

namespace App\Http\Livewire\Connect\Contact;

use App\Models\Information\Basic\Contact;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ManageContacts extends Component
{
    public $contactToEdit;
    public Collection $contacts;
    protected $listeners = [
        'contactsModified' => '$refresh'
    ];

    public function delete(Contact $contact)
    {
        $contact->delete();
        $this->emit('contactsModified');
        return;
    }

    public function back()
    {
        $this->reset('contactToEdit');
    }

    public function edit(Contact $contact)
    {
        $this->contactToEdit = $contact;
    }

    public function render()
    {
        return view('livewire.connect.contact.manage-contacts');
    }
}
