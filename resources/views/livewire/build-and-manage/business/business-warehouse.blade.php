<div>
    <div class="w-full" wire:loading>
        <x-loader_2 />
    </div>
    <div>
        @if($active_sellable)
        <div class="mb-4 ml-4 sm:ml-0">
            <x-jet-button wire:click="viewAll">
                <i class="fas fa-arrow-circle-left"></i> &nbsp; {{ __('All items') }}
            </x-jet-button>
        </div>
        <div>
            @php
            $model_name = $components[$active_sellable->item::class]['model_name'];
            $component = $components[$active_sellable->item::class]['component'];
            @endphp
            @livewire($component, ["{$model_name}" => $active_sellable->item],
            key(md5("item_dashboard_for_{$active_sellable->id}")))
        </div>
        @else
        <div x-data x-init="() => { window.scrollTo(0, 0); }"
            class="@if($business->warehouse->count() > 0) grid gap-2 sm:gap-2 grid-cols-2 sm:grid-cols-3 md:grid-cols-6 @endif px-2 sm:px-0">
            @forelse ($warehouse as $sellable)
            <div wire:click="switchActiveProduct('{{ $sellable->id }}')" class="px-3 py-3 bg-gray-100 cursor-pointer">
                <div class="flex items-center justify-center">
                    @if($sellable->item?->gallery?->first()?->image_url)
                    <img src="/storage/{{ $sellable->item->gallery->first()->image_url }}" width="150" height="150" />
                    @else
                    <div class="text-blue-700">
                        <div class="flex justify-center">
                            <i style="font-size: 5.5rem;" class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="text-center">
                            no image
                        </div>
                    </div>
                    @endif
                </div>

                <div class="pt-2 text-center">
                    <div class="truncate">
                        {{ $sellable->item->name }}
                    </div>

                    <div class="truncate">
                        {!! $sellable->item->price() !!}
                    </div>
                </div>

                @if ($sellable->item->is_published)
                <div class="px-1 py-1 text-center text-green-700">
                    <i class="fa fa-check-circle"></i> published
                </div>

                @else
                <div class="px-1 py-1 text-center text-red-700">
                    <i class="fa fa-exclamation-triangle"></i> unpublished
                </div>
                @endif
            </div>

            @empty
            <div>
                <div class="flex justify-center">
                    <i style="font-size: 8rem;" class="text-blue-700 fas fa-shopping-bag"></i>
                </div>

                <div class="px-3 py-3 text-lg font-bold text-center text-blue-700">
                    <span class="block mb-3">
                        your warehouse is empty.
                    </span>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mx-2 md:mx-0">
            <x-paginator :data="$warehouse" />
        </div>
    </div>
    @endif

    @if($active_sellable)
    <script>
        setTimeout(() => {
            window.UiHelpers.modifyUrl("/biz/{{$business->profile->full_tag()}}/warehouse/{{$active_sellable->id}}")
        }, 100);

    </script>

    @else
    <script>
        setTimeout(() => {
            window.UiHelpers.modifyUrl("/biz/{{$business->profile->full_tag()}}/warehouse")
        }, 100);

    </script>
    @endif
</div>
