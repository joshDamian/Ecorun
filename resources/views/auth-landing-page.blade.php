<x-social-layout>
    <div>
        <div x-data="{ collapsed: false }"
            x-init="() => { Livewire.on('toggled', (toggle) => { collapsed = toggle; window.scrollTo(0, 0); }) }"
            :class="(collapsed) ? '' : 'sticky top-12 sm:top-13 md:top-12'"
            class="z-40 px-3 py-2 bg-gray-100 bg-opacity-75 border-b border-gray-300 sm:py-3 sm:px-5" x-cloak>
            @livewire('connect.post.create-new-post', ['profile' => $profile, 'view' => 'landing-page'],
            key("create_new_post_auth" . microtime()))
        </div>

        <div class="sm:mb-2">
            @livewire('connect.profile.profile-feed', ['profile' => $profile, 'sortBy' => $sortBy ?? 'all'],
            key('profile_feed_auth'))
        </div>
    </div>
</x-social-layout>
