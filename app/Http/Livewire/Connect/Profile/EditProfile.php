<?php

namespace App\Http\Livewire\Connect\Profile;

use App\Models\Profile;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditProfile extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $profileId;
    public $name;
    public $photo;
    public $tag;
    public $brand;
    public $description;

    public function mount()
    {
        $this->name = $this->profile->name;
        $this->description = $this->profile->description;
        $this->tag = $this->profile->tag;
        $this->brand = $this->profile->brand;
    }

    public function update()
    {
        $this->authorize('access', $this->profile);

        $this->validate($this->rules());

        $old_tag = $this->profile->tag;
        $should_modify = $this->tag !== $old_tag;

        $this->profile->name = $this->upperCaseWords($this->name);
        $this->profile->tag = $this->tag;
        $this->profile->description = $this->description;
        $modify_brand = function () {
            if ($this->brand !== $this->profile->brand) {
                $modified = match ($this->profile->profileable_type) {
                    User::class => function () {
                        $this->profile->profileable->brand = $this->brand;
                        $this->profile->profileable->save();
                    },
                    Business::class => function () {
                        $this->profile->profileable->type = $this->brand;
                        $this->profile->profileable->save();
                    }
                };
                return $modified();
            }
            return false;
        };
        $modify_brand();
        $this->profile->save();
        if ($should_modify) {
            $this->modify_static_content($old_tag);
        }
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
                'max:30',
                Rule::unique('profiles')->ignore($this->profile),
                'alpha_dash',
            ],
            'description' => [
                'required',
                'min:4'
            ],
            'brand' => ['required', ($this->profile->isBusiness()) ? Rule::in(config('branding.brands.businesses')) : Rule::in(config('branding.brands.users'))],
            'photo' => [
                'nullable',
                'image',
                'max:6144'
            ],
        ];
    }

    public function modify_static_content($oldProfile_tag)
    {
        foreach (Post::whereJsonContains('mentions', $this->profile->id)->cursor() as $post) {
            $post->content = str_replace("@$oldProfile_tag", "@" . $this->profile->tag, $post->content);
            $post->save();
        }
    }

    public function getProfileProperty(): \App\Models\Profile
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
