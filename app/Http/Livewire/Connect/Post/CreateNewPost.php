<?php

namespace App\Http\Livewire\Connect\Post;

use App\Http\Livewire\Traits\CreatesSocialContent;
use Faker\Generator;
use Livewire\Component;

class CreateNewPost extends Component
{
    use CreatesSocialContent;

    public string $view;
    public $visibility = "public";

    public function create(Generator $generator)
    {
        $this->validate($this->defaulRules());
        $post = $this->profile->posts()->create([
            'content' => trim(htmlentities($this->text_content . PHP_EOL . $generator->paragraph)) ?? '',
            'visibility' => $this->visibility
        ]);
        $this->uploadPhotos('post-photos', $post, 'post_photo', array(1400, 1400));
        $this->emit('newPost');
        $this->emit('addedContent');
        $this->done();
        return;
    }

    public function render()
    {
        return view('livewire.connect.post.create-new-post');
    }
}
