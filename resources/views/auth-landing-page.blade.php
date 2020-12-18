<x-social-layout>
    <div>
        <div>
            <div class="sticky mb-3 bg-gray-100 top-12 md:mb-3 sm:shadow sm:rounded">
                @livewire('connect.post.create-new-post', ['profile' => Auth::user()->currentProfile, 'view' => 'landing-page'])
            </div>

            <div class="sm:mb-4">
                @livewire('connect.profile.profile-post-list', ['profile' => Auth::user()->currentProfile, 'view' => 'landing-page'])
            </div>
        </div>
    </div>
</x-social-layout>
