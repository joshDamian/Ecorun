<?php

namespace App\Http\Livewire\Posts;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateNewPost extends Component
{
    use WithFileUploads;

    public $profile;
    public $photos = [];
    public $content;
    public $empty;
    public $ready;

    public function create()
    {
        $this->validate([
            'content' => Rule::requiredIf(count($this->photos) === 0),
            'photos' => Rule::requiredIf(empty(trim($this->content))),
            'photos.*' => ['image', 'max:5120']
        ]);

        $post = $this->profile->posts()->create([
            'content' => trim($this->content) ?? '',
            'visibility' => 'public'
        ]);

        if (count($this->photos) > 0) {
            foreach ($this->photos as $photo) {
                $post->gallery()->create([
                    'image_url' => $photo->store('post-photos', 'public'),
                    'label' => 'post_photo'
                ]);
            }
        }

        return $this->done();
    }

    public function done()
    {
        $this->photos = [];
        $this->content = null;
        $this->ready = null;
        return $this->resetErrorBag();
    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => ['image', 'max:5120']
        ]);
    }

    public function ready()
    {
        $this->ready = true;
    }

    public function render()
    {
        return view('livewire.posts.create-new-post');
    }
}
