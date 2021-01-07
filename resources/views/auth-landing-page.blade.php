<x-social-layout>
    <div>
        <div>
            <div class="sticky mb-2 bg-gray-100 bg-opacity-75 top-12" x-cloak>
                @livewire('connect.post.create-new-post', ['profile' => $profile, 'view' => 'landing-page'],
                key(md5('create_new_post_auth')))
            </div>

            <div class="sm:mb-2">
                @livewire('connect.profile.profile-feed', ['profile' => $profile, 'sortBy' => $sortBy ?? 'all'],
                key(md5('profile_feed_auth')))
            </div>
        </div>
    </div>
</x-social-layout>