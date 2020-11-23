<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-1">
        <div>
            <div class="bg-gray-100 mb-2 md:mb-3 sm:shadow sm:rounded">
                @livewire('posts.create-new-post', ['profile' => Auth::user()->profile, 'view' => 'landing-page'])
            </div>

            <div class="sm:mb-4">
                @livewire('posts.profile-post-list', ['profile' => Auth::user()->profile, 'view' => 'landing-page'])
            </div>
        </div>
    </div>
</x-app-layout>
