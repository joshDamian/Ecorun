<x-social-layout>
    @livewire('connect.post.edit-post', ['post' => $post, 'profile' => Auth::user()->currentProfile], key("edit_post" .
    $post->id))
</x-social-layout>
