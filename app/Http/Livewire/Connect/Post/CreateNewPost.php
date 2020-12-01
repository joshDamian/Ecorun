<?php

namespace App\Http\Livewire\Connect\Post;

use App\Http\Livewire\Connect\Traits\CreateNewContent;
use Livewire\Component;

class CreateNewPost extends Component
{
    use CreateNewContent;

    public $view;

    public function create()
    {
        $this->defaultContentValidation();

        $post = $this->profile->posts()->create([
            'content' => trim($this->content) ?? '',
            'visibility' => 'public'
        ]);

        $this->uploadPhotos('post-photos', $post, 'post_photo', array(1400, 1400));

        return $this->done();
    }

    public function render()
    {
        return view('livewire.connect.post.create-new-post');
    }
}
