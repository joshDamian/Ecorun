<div>
    <div class="grid grid-cols-1 sm:gap-4 sm:grid-cols-6">
        <div class="mx-4 mb-2 sm:col-span-2 md:mx-0 sm:mb-0">
            <h3 class="text-lg font-medium text-gray-900">
                {{ __('About ') . $business->name }}
            </h3>
            <p class="text-gray-600">
                Describe your business to help customers find you.
            </p>
        </div>
        <div class="sm:col-span-4">
            @if($business->profile)
            <div>
                @livewire('connect.profile.edit-profile', ['profile' => $business->profile])
            </div>
            @else
            <div>
                @livewire('connect.profile.create-new-profile', ['profileable' => $business])
            </div>
            @endif
        </div>
    </div>
</div>