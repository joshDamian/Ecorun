<?php

namespace App\Http\Livewire\Enterprise;

use Livewire\Component;
use App\Models\Enterprise;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class EditEnterprise extends Component
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
            'max:3072'
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
            $photo_path = $this->photo->store('entreprise-cover-photos', 'public');
            /*$cover_photo = Image::make(public_path("/storage/{$photo_path}"))->fit(640, 320);
            $cover_photo->save();*/

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
            }
        }

        $this->enterprise->name = ucwords($this->enterprise->name);
        $this->enterprise->save();
        $this->emitSelf('saved');
        $this->emit('enterprise_updated');
    }

    public function deleteCoverPhoto()
    {
        if ($this->enterprise->coverPhoto()) {
            Storage::disk('public')->delete($this->enterprise->coverPhoto());
            $this->enterprise->gallery()
                ->where('label', 'cover_photo')
                ->delete();

            $this->emitSelf('saved');
            $this->emit('enterprise_updated');
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
        return view('livewire.enterprise.edit-enterprise');
    }
}
