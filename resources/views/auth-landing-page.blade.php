<x-social-layout>
    <div>
<<<<<<< HEAD
        <div>
            <div x-data="{ collapsed: false }"
                x-init="() => { Livewire.on('toggled', (toggle) => { collapsed = toggle; window.scrollTo(0, 0); }) }"
                :class="(collapsed) ? '' : 'sticky top-12 sm:top-13 md:top-12'" class="bg-gray-100 bg-opacity-75 "
                x-cloak>
                @livewire('connect.post.create-new-post', ['profile' => $profile, 'view' => 'landing-page'],
                key(md5('create_new_post_auth')))
            </div>
=======
        <div x-data="{ collapsed: false }"
            x-init="() => { Livewire.on('toggled', (toggle) => { collapsed = toggle; window.scrollTo(0, 0); }) }"
            :class="(collapsed) ? '' : 'sticky top-12 sm:top-13'" class="bg-gray-100 bg-opacity-75 border-b border-gray-300 px-3 py-2" x-cloak>
            @livewire('connect.post.create-new-post', ['profile' => $profile, 'view' => 'landing-page'],
            key(md5('create_new_post_auth')))
        </div>
>>>>>>> a0bdf9a4c59e89014ceab59ba3e9d1d9d519840e

        <div class="sm:mb-2">
            @livewire('connect.profile.profile-feed', ['profile' => $profile, 'sortBy' => $sortBy ?? 'all'],
            key(md5('profile_feed_auth')))
        </div>
    </div>
</x-social-layout>
