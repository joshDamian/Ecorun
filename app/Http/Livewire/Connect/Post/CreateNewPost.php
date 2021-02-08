<?php

namespace App\Http\Livewire\Connect\Post;

use App\Http\Livewire\Traits\CreatesSocialContent;
use Livewire\Component;

class CreateNewPost extends Component
{
    use CreatesSocialContent;

    public string $view;
    public $visibility = "public";

    public function create()
    {
        $this->validate($this->validationRules());
        $post = $this->profile->posts()->create([
            'content' => trim($this->text_content) ?? '',
            'visibility' => $this->visibility
        ]);
        $this->emit('newPost');
        $this->emit('addedContent');
        if (count($this->photos) > 0) {
            $this->uploadPhotos('post-photos', $post, 'post_photo');
        }
        return $this->done();
    }

    public function extra_validation(): array
    {
        return [];
    }

    public function render()
    {
        return view('livewire.connect.post.create-new-post');
    }
}
