<x-app-layout>
    <div class="grid grid-cols-1 md:gap-4 md:grid-cols-4">
        <div class="md:col-span-3">
            <div class="mb-3 bg-gray-100 md:mb-3 sm:shadow sm:rounded">
                @livewire('connect.post.create-new-post', ['profile' => Auth::user()->currentProfile, 'view' => 'landing-page'])
            </div>

            <div class="sm:mb-4">
                @livewire('connect.profile.profile-post-list', ['profile' => Auth::user()->currentProfile, 'view' => 'landing-page'])
            </div>
        </div>
    </div>
</x-app-layout>
