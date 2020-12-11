<?php

namespace App\Http\Livewire\Connect\Post;

use App\Http\Livewire\Traits\CreateProfileContent;
use Livewire\Component;

class CreateNewPost extends Component
{
    use CreateProfileContent;

    public $view;
    public $visibility = "public";

    public function create()
    {
        $this->defaultContentValidation();

        $post = $this->profile->posts()->create([
            'content' => trim($this->content) ?? '',
            'visibility' => $this->visibility
        ]);

        $this->uploadPhotos('post-photos', $post, 'post_photo', array(1400, 1400));

        return $this->done();
    }

    public function render()
    {
        return view('livewire.connect.post.create-new-post');
    }
}
