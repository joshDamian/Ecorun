<div>
    <div class="grid grid-cols-1 sm:gap-4 sm:grid-cols-6">
        <div class="sm:col-span-2 mx-4 md:mx-0 mb-2 sm:mb-0">
            <h3 class="text-lg font-medium text-gray-900">
                {{ __('About ') . $enterprise->name }}
            </h3>
            <p class="text-gray-600">
                Describe your business to help customers find you.
            </p>
        </div>
        <div class="sm:col-span-4">
            @if($enterprise->profile)
            <div>
                @livewire('profile.edit-profile', ['profile' => $enterprise->profile])
            </div>
            @else
            <div>
                @livewire('profile.create-new-profile', ['profileable' => $enterprise])
            </div>
            @endif
        </div>
    </div>
</div>
