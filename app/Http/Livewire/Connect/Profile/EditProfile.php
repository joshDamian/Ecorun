<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Profile;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    public Profile $profile;
    public $photo;
    protected $rules = [
        'profile.name' => ['required', 'min:4'],
        'profile.eco_tag' => ['required', 'unique:profiles,eco_tag'],
        'profile.description' => ['required', 'min:20'],
        'photo' => ['nullable', 'image', 'max:1024'],
    ];

    public function update()
    {
        $current_tag = Profile::find($this->profile->id)->eco_tag;
        $this->validate([
            'profile.name' => ['required', 'min:4'],
            'profile.eco_tag' => ($this->profile->eco_tag !== $current_tag) ? [
                'required',
                'min:4',
                'unique:profiles,eco_tag'
            ] :
                [
                    'required',
                    'min:4',
                ],
            'profile.description' => ['required', 'min:20'],
            'photo' => ['nullable', 'image', 'max:1024'],
        ]);

        $this->profile->save();

        if ($this->photo) {
            $this->profile->updateProfilePhoto($this->photo);
        }
        $this->emitSelf('saved');

        return redirect('/user/profile/edit');
    }

    public function render()
    {
        return view('livewire.connect.profile.edit-profile');
    }
}
