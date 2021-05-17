<?php

namespace App\Http\Livewire\Connect\Contact;

use Livewire\Component;
use App\Models\Information\Basic\Contact;

class AddContact extends Component
{
    public $phone_number;
    public object $contactable;
    protected $listeners = [
        'added'
    ];

    public function addContact()
    {
        $this->validate();
        if (auth()->user()->can('create', [Contact::class, $this->contactable])) {
            $this->contactable->contacts()->create([
                'phone' => $this->phone_number
            ]);
            $this->emitSelf('added');
        } else {
            $this->addError('phone_number', 'you have reached the maximum amount of allowed phone numbers.');
        }
        return;
    }

    public function added()
    {
        $this->reset('phone_number');
        $this->emit('contactsModified');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function rules()
    {
        return [
            'phone_number' => ['required', 'digits_between:10,11'],
        ];
    }

    public function render()
    {
        return view('livewire.connect.contact.add-contact');
    }
}
