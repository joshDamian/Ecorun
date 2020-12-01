<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use Livewire\Component;
use App\Models\Business;
use Livewire\WithFileUploads;

class EditBusiness extends Component
{
    use WithFileUploads;

    public Business $business;
    public $photo;

    protected $listeners = [
        'saved' => '$refresh'
    ];

    protected $rules = [
        'business.name' => [
            'required',
            'min:4',
            'unique:businesses,name'
        ],

        'photo' => [
            'sometimes',
            'required',
            'image',
            'max:5120'
            /** 3MB Max */
        ]
    ];

    public function saveProfile()
    {
        $current_name = Business::find($this->business->id)->name;
        $this->validate([
            'business.name' => ($this->business->name !== $current_name) ? [
                'required',
                'min:4',
                'unique:businesses,name'
            ] :
                [
                    'required',
                    'min:4',
                ]
        ]);

        if ($this->photo) {
            $this->business->updateProfilePhoto($this->photo);
        }

        $this->business->name = ucwords($this->business->name);
        $this->business->save();
        $this->emitSelf('saved');
        $this->emit('business_updated');
    }

    public function deleteCoverPhoto()
    {
        if ($this->business->profile_photo_path) {
            $this->business->deleteProfilePhoto();
            $this->emitSelf('saved');
            $this->emit('business_updated');
        }
    }

    public function updated($propertyName)
    {
        $current_name = Business::find($this->business->id)->name;
        $this->validateOnly($propertyName, [
            'business.name' => ($this->business->name !== $current_name) ? [
                'required',
                'min:4',
                'unique:businesses,name'
            ] :
                [
                    'required',
                    'min:4',
                ],
        ]);
    }

    public function render()
    {
        return view('livewire.build-and-manage.business.edit-business');
    }
}
