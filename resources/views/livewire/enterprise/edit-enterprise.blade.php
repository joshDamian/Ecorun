<div>
    <x-jet-form-section submit="saveProfile">
        @if ($enterprise->isStore())
        <x-slot name="title">
            {{ __('Store Profile') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Edit your store\'s name and cover photo.') }}
        </x-slot>
        @else
        <x-slot name="title">
            {{ __('Service Profile') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Edit your service\'s name and cover photo.') }}
        </x-slot>
        @endif

        <x-slot name="form">
            <!-- Photo -->
            <div x-data="{photoPreview: null, photoName: null, isUploading: false, progress: 0}" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" x-init="@this.on('saved', () => { setTimeout( () => { photoPreview = null; }, 1000); })" class="col-span-6 sm:col-span-4">

                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" accept="image/*" wire:model="photo" x-ref="photo" x-on:change="
                    photoName = $refs.photo.files[0].name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                    photoPreview = e.target.result;
                    };
                    reader.readAsDataURL($refs.photo.files[0]);
                    " />

                <x-jet-label for="photo" value="{{ __('Cover Photo') }}" />

                <!-- Current Cover Photo -->
                <div class="mt-2" x-show.transition="! photoPreview">
                    <div style="height: 220px; width: 100%; background-image: url('{{ $enterprise->profile_photo_url }}'); background-position: center center; background-size: cover;">
                    </div>
                </div>

                <!-- New Cover Photo Preview -->
                <div class="mt-2" x-show.transition="photoPreview">
                    <div x-bind:style="'width: 100%; height: 200px; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </div>
                    <div class="mt-2" x-show.transition="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click(); photoPreview = null">
                    {{ __('Select A New Cover Photo') }}
                </x-jet-secondary-button>
                <x-jet-input-error for="photo" class="mt-2" />
            </div>

            <!-- Name -->
            @if ($enterprise->isStore())
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Store Name') }}" />
                <x-jet-input id="name" placeholder="store name" type="text" wire:model="enterprise.name" class="mt-1 block w-full" autocomplete="name" />
                <x-jet-input-error for="enterprise.name" class="mt-2" />
            </div>
            @else
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Service Name') }}" />
                <x-jet-input id="name" placeholder="service name" type="text" wire:model="enterprise.name" class="mt-1 block w-full" autocomplete="name" />
                <x-jet-input-error for="enterprise.name" class="mt-2" />
            </div>
            @endif

            <!-- Remove Cover Photo -->
            @if($enterprise->profile_photo_path)
            <div class="col-span-6 sm:col-span-4">
                <x-jet-secondary-button wire:click="deleteCoverPhoto">
                    {{ __('Remove Cover Photo') }}
                </x-jet-secondary-button>
            </div>
            @endif
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
