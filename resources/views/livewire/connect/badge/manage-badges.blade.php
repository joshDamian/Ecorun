<div x-data="{ show_create_form: false }" x-init="() => {
    if($refs.other_badges.innerText === '') {
    $refs.other_badges_label.classList.add('hidden');
    }
    @this.on('refresh', (event) => {
    show_create_form = false;
    })
    }">
    <h3 class="mb-1 text-gray-600 text-md">Badges</h3>
    <div class="px-4 py-3 border border-gray-200">
        <div class="px-3 py-2 mb-2 text-md font-semibold text-gray-700 uppercase bg-gray-200">
            Manage badges
        </div>
        <div class="w-6/12">
            <x-connect.badge.badge-card :badge="$primaryBadge" :isDisplayBadge="true" />
        </div>
        <div x-show="$refs.other_badges.innerText !== ''" x-ref="other_badges_label" class="mt-4 text-gray-600">
            Other badges
        </div>
        <div x-ref="other_badges" class="flex flex-wrap items-center">
            @foreach($attachedBadges as $key => $badge)
            @if($badge->id === $primaryBadge->id)
            @continue
            @endif
            <div class="@if(!$loop->last) mr-4 @endif mb-4">
                <x-connect.badge.badge-card :badge="$badge" />
            </div>
            @endforeach
        </div>

        @if($detachedBadges->count() > 0)
        <div>
            <div class="text-gray-600">
                Add new badge
            </div>
            <div class="flex items-center">
                <div>
                    <select class="form-select" x-ref="new_badge">
                        @foreach($detachedBadges as $key => $badge)
                        <option @if($loop->last) selected @endif value="{{ $badge->id }}">{{ $badge->label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="ml-3">
                    <i x-on:click="$wire.getInfo($refs.new_badge.value).then(result => {
                        $refs.info_display.classList.remove('hidden');
                        $refs.info_display.innerText = result;
                        })" class="text-gray-700 cursor-pointer fas fa-info-circle"></i>
                </div>
                <x-jet-secondary-button x-on:click="$wire.add($refs.new_badge.value)"
                    class="ml-6 text-green-500 border-green-500">
                    add
                </x-jet-secondary-button>
            </div>
            <div class="hidden p-2 text-gray-700" x-ref="info_display"></div>
        </div>
        @endif

        <div x-on:click="show_create_form = ! show_create_form"
            class="flex @if($detachedBadges->count() > 0) mt-6 @else mt-2 @endif justify-between px-3 py-2 text-md font-semibold text-gray-700 uppercase bg-gray-200 cursor-pointer">
            <span class="flex-1">Create a badge</span>
            <span><i :class="(show_create_form) ? 'fa-chevron-up' : 'fa-chevron-down' " class="fas"></i></span>
        </div>

        <div x-show="show_create_form" class="grid grid-cols-1 gap-3 mt-2">
            <div>
                <x-jet-label value="Badge label" />
                <x-jet-input class="w-full mt-1" name="badge_label" wire:model="badge.label" />
                <x-jet-input-error class="mt-1" for="badge.label" />
            </div>

            <div>
                <x-jet-label value="What does this badge represent?" />
                <textarea class="w-full mt-1 form-textarea" name="badge_description"
                    wire:model="badge.description"></textarea>
                <x-jet-input-error class="mt-1" for="badge.description" />
            </div>

            <div>
                <x-jet-label value="Badge for?" />
                <select wire:model="badge.for" class="form-select">
                    <option value="{{ __('user') }}">users</option>
                    <option value="{{ __('business') }}">businesses</option>
                </select>
                <x-jet-input-error class="mt-1" for="badge.for" />
            </div>

            <div class="flex justify-end">
                <x-jet-button wire:click="createBadge" type="button" class="bg-blue-700">
                    create
                </x-jet-button>
            </div>
        </div>
    </div>
</div>