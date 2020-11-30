<?php

namespace App\Http\Livewire\BuildAndManage\Business;

use Livewire\Component;
use App\Models\Enterprise;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class EditBusiness extends Component
{
    use WithFileUploads;

    public Enterprise $enterprise;
    public $photo;

    protected $listeners = [
        'saved' => '$refresh'
    ];

    protected $rules = [
        'enterprise.name' => [
            'required',
            'min:4',
            'unique:enterprises,name'
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
        $current_name = Enterprise::find($this->enterprise->id)->name;
        $this->validate([
            'enterprise.name' => ($this->enterprise->name !== $current_name) ? [
                'required',
                'min:4',
                'unique:enterprises,name'
            ] :
                [
                    'required',
                    'min:4',
                ]
        ]);

        if ($this->photo) {
            $this->enterprise->updateProfilePhoto($this->photo);
            /* $photo_path = $this->photo->store('enterprise-cover-photos', 'public');

            if ($this->enterprise->coverPhoto()) {
                Storage::disk('public')->delete($this->enterprise->coverPhoto());
                $this->enterprise->gallery()
                    ->where('label', 'cover_photo')
                    ->update(['image_url' => $photo_path]);
            } else {
                $this->enterprise->gallery()->create([
                    'label' => 'cover_photo',
                    'image_url' => $photo_path
                ]);
            } */
        }

        $this->enterprise->name = ucwords($this->enterprise->name);
        $this->enterprise->save();
        $this->emitSelf('saved');
        $this->emit('enterprise_updated');
    }

    public function deleteCoverPhoto()
    {
        if ($this->enterprise->profile_photo_path) {
            $this->enterprise->deleteProfilePhoto();
            /* Storage::disk('public')->delete($this->enterprise->coverPhoto());
            $this->enterprise->gallery()
                ->where('label', 'cover_photo')
                ->delete();

            $this->emitSelf('saved');
            $this->emit('enterprise_updated'); */
        }
    }

    public function updated($propertyName)
    {
        $current_name = Enterprise::find($this->enterprise->id)->name;
        $this->validateOnly($propertyName, [
            'enterprise.name' => ($this->enterprise->name !== $current_name) ? [
                'required',
                'min:4',
                'unique:enterprises,name'
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
