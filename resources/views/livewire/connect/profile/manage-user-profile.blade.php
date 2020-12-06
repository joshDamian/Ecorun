<div>
    <div class="grid grid-cols-1 sm:gap-4 sm:grid-cols-6">
        <div class="mx-4 mb-3 sm:col-span-2 sm:mb-0 sm:mx-0">
            <h3 class="text-lg font-medium text-gray-900">
                Profile Information
            </h3>
            <p class="text-gray-600">
                Express who you are: update your name, profile-photo, eco-tag and description.
            </p>
        </div>
        <div class="sm:col-span-4">
            @if(Auth::user()->currentProfile)
            <div>
                @livewire('connect.profile.edit-profile', ['profile' => Auth::user()->currentProfile])
            </div>

            @else
            <div>
                @livewire('connect.profile.create-new-profile', ['profileable' => Auth::user()])
            </div>
            @endif
        </div>
    </div>
</div>
