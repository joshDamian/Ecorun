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
        $this->defaultContentValidation();

        $post = $this->profile->posts()->create(
            [
            'content' => trim($this->content) ?? '',
            'visibility' => $this->visibility
            ]
        );

        $this->uploadPhotos('post-photos', $post, 'post_photo', array(1400, 1400));

        $this->emit('addedContent');

        $this->emit('newPost');

        $this->done();

        event(new PostCreated($post));
        
        return;
    }
    
    public function render()
    {
        return view('livewire.connect.post.create-new-post');
    }
}
