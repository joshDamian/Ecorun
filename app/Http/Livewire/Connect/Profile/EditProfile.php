<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Profile;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditProfile extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $profileId;
    public $name;
    public $photo;
    public $tag;
    public $description;

    public function mount()
    {
        $this->name = $this->profile->name;
        $this->description = $this->profile->description;
        $this->tag = $this->profile->tag;
    }


    public function update(Request $request)
    {
        $this->authorize('access', $this->profile);

        $this->validate($this->rules());

        $this->profile->name = $this->upperCaseWords($this->name);
        $this->profile->tag = strtolower($this->tag);
        $this->profile->description = $this->description;

        $this->profile->save();

        if ($this->photo) {
            $this->profile->updateProfilePhoto($this->photo);
        }

        $this->emitSelf('saved');

        return redirect($this->profile->url->edit);
    }

    public function deleteProfilePhoto()
    {
        $this->authorize('access', $this->profile);
        return $this->profile->deleteProfilePhoto();
    }

    protected function rules(): array
    {
        return  [
            'name' => [
                'required',
                'min:4',
                'max:255',

                Rule::unique('profiles', 'name')->where(
                    function ($query) {
                        return $query->where('profileable_type', 'App\Models\Business');
                    }
                )->ignore($this->profile)
            ],

            'tag' => [
                'required',
                'min:4',
                'max:20',
                Rule::unique('profiles')->ignore($this->profile),
                'alpha_dash',
            ],

            'description' => [
                'required',
                'min:20'
            ],

            'photo' => [
                'nullable',
                'image',
                'max:3072'
            ],
        ];
    }

    public function getProfileProperty()
    {
        return Profile::findOrFail($this->profileId);
    }

    public function messages()
    {
        return [
            'name.unique' => 'That\'s a registered business name.'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    protected function upperCaseWords(string $string)
    {
        return ucwords(strtolower($string));
    }

    public function render()
    {
        return view(
            'livewire.connect.profile.edit-profile',
            [
                'tag_prefix' => Profile::TAG_PREFIX
            ]
        );
    }
}
