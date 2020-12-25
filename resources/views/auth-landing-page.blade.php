<x-social-layout>
    <div>
        <div>
            <div class="sticky mb-3 bg-gray-100 top-12 md:mb-3 sm:shadow sm:rounded">
                @livewire('connect.post.create-new-post', ['profile' => $profile, 'view' => 'landing-page'], key(md5('create_new_post_auth')))
            </div>

            <div class="sm:mb-4">
                @livewire('connect.profile.profile-post-list', ['profile' => $profile->loadMissing('following'), 'view' => 'landing-page', 'currentProfile' => $profile], key(md5('profile_post_list_auth')))
            </div>
        </div>
    </div>
</x-social-layout>
