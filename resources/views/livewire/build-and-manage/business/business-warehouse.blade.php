<div>
    <div class="w-full mb-2" wire:loading>
        <x-loader_2 />
    </div>
    <div>
        @if($active_item)
        <div class="mb-4 ml-4 sm:ml-0">
            <x-jet-button wire:click="viewAll">
                <i class="fas fa-arrow-circle-left"></i> &nbsp; {{ __('All items') }}
            </x-jet-button>
        </div>
        <div>
            @php
            $component = $components[$active_item->sellable->sellable_name->lower()->__toString()]['component'];
            @endphp
            @livewire($component, ["item" => $active_item],
            key(md5("item_dashboard_for_{$active_item->id}")))
        </div>
        @else
        <div x-data x-init="() => { window.scrollTo(0, 0); }"
            class="@if($business->warehouse->count() > 0) grid gap-2 sm:gap-2 grid-cols-2 sm:grid-cols-3 md:grid-cols-6 @endif px-2 sm:px-0">
            @forelse ($warehouse as $item)
            <div wire:click="switchActiveItem('{{ $item->id }}')" class="px-3 py-3 bg-gray-100 cursor-pointer">
                <div class="flex items-center justify-center">
                    @if($item->sellable?->gallery?->first()?->image_url)
                    <img src="/storage/{{ $item->sellable->gallery->first()->image_url }}" width="150" height="150" />
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
                        {{ $item->sellable->name }}
                    </div>

                    <div class="truncate">
                        @if($item->sellable->price)
                        {!! $item->sellable->price() !!}
                        @else
                        {{ __('quotation') }}
                        @endif
                    </div>
                </div>

                @if ($item->is_published)
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
                <div class="flex items-center justify-center h-full">
                    <i style="font-size: 6rem;" class="text-blue-700 fas fa-warehouse"></i>
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

    @if($active_item)
    <script>
        setTimeout(() => {
            window.UiHelpers.modifyUrl("/biz/{{$business->profile->full_tag()}}/warehouse/{{$active_item->id}}")
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
