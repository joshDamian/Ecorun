<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Profile;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    public Profile $profile;
    public $photo;
    public $eco_tag;
    protected $rules = [
        'profile.name' => [
            'required',
            'min:4'
        ],
        'profile.eco_tag' => [
            'required',
            'unique:profiles,eco_tag'
        ],
        'profile.description' => [
            'required',
            'min:20'
        ],
        'photo' => [
            'nullable',
            'image',
            'max:1024'
        ],
    ];


    public function update()
    {
        $current_tag = Profile::find($this->profile->id)->eco_tag;
        $this->validate([
            'profile.name' => [
                'required',
                'min:4',
            ],
            'profile.eco_tag' => ($this->profile->eco_tag !== $current_tag) ? [
                'required',
                'min:4',
                'unique:profiles,eco_tag',
                'alpha_dash'
            ] :
                [
                    'required',
                    'min:4',
                    'alpha_dash'
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

    public function updated($propertyName)
    {
        $current_tag = Profile::find($this->profile->id)->eco_tag;
        $this->validateOnly($propertyName, [
            'profile.name' => ['required', 'min:4'],
            'profile.eco_tag' => ($this->profile->eco_tag !== $current_tag) ? [
                'required',
                'min:4',
                'unique:profiles,eco_tag',
                'alpha_dash'
            ] :
                [
                    'required',
                    'min:4',
                    'alpha_dash'
                ],
            'profile.description' => ['required', 'min:20'],
            'photo' => ['nullable', 'image', 'max:1024'],
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'profile.eco_tag.required' => 'The eco-tag field is required',
            'profile.eco_tag.unique' => 'This eco-tag is unavailable',
            'profile.eco_tag.min' => 'An eco-tag should be at least :min characters',
            'profile.eco_tag.alpha_dash' => 'An eco-tag may only contain letters, numbers, dashes and underscores',
        ];
    }

    public function render()
    {
        return view('livewire.connect.profile.edit-profile', [
            'tag_suffix' => Profile::TAG_SUFFIX
        ]);
    }
}
