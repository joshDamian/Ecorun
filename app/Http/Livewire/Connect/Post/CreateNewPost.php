<?php

namespace App\Http\Livewire\Connect\Post;

use App\Events\PostCreated;
use App\Http\Livewire\Traits\CreateSocialContent;
use Livewire\Component;

class CreateNewPost extends Component
{
    use CreateSocialContent;

    public $view;
    public $visibility = "public";

    public function create()
    {
        $this->validate();
        $post = $this->profile->posts()->create(
            [
            'content' => trim($this->content) ?? '',
            'visibility' => $this->visibility
            ]
        );
        $this->uploadPhotos('post-photos', $post, 'post_photo', array(1400, 1400));
        $this->emit('newPost');
        $this->emit('addedContent');
        $this->done();
        broadcast(new PostCreated($post))->toOthers();
        return;
    }
    
    public function render()
    {
        return view('livewire.connect.post.create-new-post');
    }
}
