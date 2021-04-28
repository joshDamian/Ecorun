<?php

namespace App\Http\Livewire\Connect\Post;

use App\Http\Livewire\Traits\CreatesSocialContent;
use Livewire\Component;
use App\Events\PostCreated;
use App\Models\Connect\Content\Post;

class CreateNewPost extends Component
{
    use CreatesSocialContent;

    public string $view;
    public $visibility = "public";
    private Post $post;

    public function create()
    {
        $this->validate($this->validationRules());
        $this->post = $this->profile->posts()->create([
            'content' => trim($this->text_content) ?? '',
            'visibility' => $this->visibility
        ]);
        $this->uploadPhotos(photos: $this->photos, folder: 'post-photos', imageable: $this->post, label: 'post_photo', sizes: null);
        $this->uploadMusic($this->post)->uploadAudio($this->post)->broadcast(PostCreated::class, $this->post)->done();
        $this->emit('newPost');
        $this->emit('addedContent');
        return;
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
