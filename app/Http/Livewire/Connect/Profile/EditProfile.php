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

    public function mount() {
        $this->name = $this->profile->name;
        $this->description = $this->profile->description;
        $this->tag = $this->profile->tag;
    }

    public function update(Request $request) {
        $this->authorize('update', $this->profile);

        $this->validate($this->rules());

        $this->profile->name = $this->upperCaseWords($this->name);
        $this->profile->tag = strtolower($this->tag);
        $this->profile->description = $this->description;

        $this->profile->save();

        if ($this->photo) {
            $this->profile->updateProfilePhoto($this->photo);
        }

        $request->user()->switchProfile($this->profile);

        $this->emitSelf('saved');

        return redirect("/{$request->user()->profile->data_slug('name')}/@{$this->profile->tag}");
    }

    public function deleteProfilePhoto() {
        return $this->profile->deleteProfilePhoto();
    }

    protected function rules() :array {
        return  [
            'name' => [
                'required',
                'min:4',
                'max:255',
                ($this->profile->isBusiness() && strtolower($this->profile->name) !== strtolower($this->name)) ?
                Rule::unique('profiles', 'name')->where(function ($query) {
                    return $query->where('profileable_type', 'App\Models\Business');
                })
                : '',
            ],

            'tag' => (strtolower($this->profile->tag) !== strtolower($this->tag)) ? [
                'required',
                'min:4',
                'max:15',
                'unique:profiles,tag',
                'alpha_dash'
            ] :
            [
                'required',
                'min:4',
                'alpha_dash'
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

    public function getProfileProperty() {
        return Profile::find($this->profileId);
    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName, $this->rules());
    }

    protected function upperCaseWords(string $string) {
        return ucwords(strtolower($string));
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */

    public function messages() {
        return [
            'name.unique' => 'This business name has been taken',
            'profile.tag.required' => 'The eco-tag field is required',
            'profile.tag.unique' => 'This eco-tag is unavailable',
            'profile.tag.min' => 'An eco-tag should be at least :min characters',
            'profile.tag.alpha_dash' => 'An eco-tag may only contain letters, numbers, dashes and underscores',
        ];
    }

    public function render() {
        return view('livewire.connect.profile.edit-profile', [
            'tag_prefix' => Profile::TAG_PREFIX
        ]);
    }
}