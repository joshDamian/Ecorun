<div class="grid grid-cols-1 mt-6 sm:mt-0 sm:gap-4 sm:grid-cols-6">
    <div class="mb-4 sm:col-span-2 sm:mb-0 sm:mx-0">
        <x-jet-section-title>
            <x-slot name="title">
                Manage Phone numbers ({{ $contacts->count() }})
            </x-slot>
            <x-slot name="description">
                Remove, edit your phone numbers.
            </x-slot>
        </x-jet-section-title>
    </div>
    <div class="p-3 bg-white sm:col-span-4 sm:p-5 bg sm:rounded-lg sm:shadow-md">
        @if($contactToEdit)
        <div class="mb-4">
            <x-jet-button wire:click="back" class="text-lg bg-blue-700">
                <i class="fas fa-chevron-left"></i>
            </x-jet-button>
        </div>
        <div>
            @livewire('connect.contact.edit-contact', ['contact' => $contactToEdit])
        </div>
        @else
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            @foreach($contacts as $key => $contact)
            <div class="grid grid-cols-1 gap-1 p-3 bg-gray-200">
                <div class="flex items-center justify-between font-semibold">
                    <div class="mr-2">+234{{ number_format($contact->phone, 0, '.', '-') }}</div>
                    <div class="flex justify-end">
                        <x-jet-secondary-button wire:click="edit({{ $contact->id }})" class="text-green-500">
                            <i class="fas fa-edit"></i>
                        </x-jet-secondary-button>
                    </div>
                </div>
                <div class="flex justify-between items-between">
                    <div class="mr-2">
                        @if($contact->phone_verified_at)
                        <span class="text-lg font-bold text-green-500">
                            <i class="mr-2 fas fa-check-circle"></i>verified
                        </span>
                        @else
                        <span class="text-lg font-bold text-red-500">
                            <i class="mr-2 fa fa-exclamation-triangle"></i>verify
                        </span>
                        @endif
                    </div>

                    <div class="flex justify-end">
                        <x-jet-secondary-button wire:click="delete({{ $contact->id }})" class="text-red-500">
                            <i class="fas fa-trash"></i>
                        </x-jet-secondary-button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
