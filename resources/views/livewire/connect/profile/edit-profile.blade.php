<div class="pt-3 bg-white shadow md:rounded-lg">
    <form wire:submit.prevent="update">
        <div class="grid grid-cols-1 gap-3 px-4 md:gap-4 md:px-6">
            <!-- Profile Photo -->
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="">
                <!-- Profile Photo File Input -->
                <input type="file" accept="image/*" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                    photoName = $refs.photo.files[0].name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                    photoPreview = e.target.result;
                    };
                    reader.readAsDataURL($refs.photo.files[0]);
                    " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->profile->profile_photo_url }}" alt="{{ $this->profile->name }}" class="object-cover w-20 h-20 rounded-full">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block w-20 h-20 rounded-full" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->profile->profile_photo_path)
                <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                    {{ __('Remove Photo') }}
                </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
            @endif

            <!-- Name -->
            <div class="">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model="profile.name" autocomplete="name" />
                <x-jet-input-error for="profile.name" class="mt-2" />
            </div>

            <!-- Eco-tag -->
            <div class="">
                <x-jet-label for="eco_tag" value="{{ __('Eco-tag') }}" />
                <x-jet-input id="eco_tag" type="text" class="block w-full mt-1" wire:model="profile.eco_tag" autocomplete="eco_tag" />
                <x-jet-input-error for="profile.eco_tag" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="description" value="{{ __('About Me') }}" />
                <textarea id="description" rows="4" class="block w-full mt-1 form-input" placeholder="enter description" wire:model="profile.description" autocomplete="description"></textarea>
                <x-jet-input-error for="profile.description" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end px-4 py-3 text-right md:rounded-b-lg bg-gray-50 sm:px-6">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </div>
    </form>
</div>
