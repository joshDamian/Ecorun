<x-app-layout>
    <div class="grid grid-cols-1 md:gap-4 md:grid-cols-3">
        <div class="md:col-span-2">
            <div class="bg-gray-100 mb-2 md:mb-3 sm:shadow sm:rounded">
                @livewire('connect.post.create-new-post', ['profile' => Auth::user()->profile, 'view' => 'landing-page'])
            </div>

            <div class="sm:mb-4">
                @livewire('profile.profile-post-list', ['profile' => Auth::user()->profile, 'view' => 'landing-page'])
            </div>
        </div>
    </div>
</x-app-layout>