<div>
    @if(!$active_product)
    <div class="fixed right-0 top-14">
        <a href="{{ route('business.dashboard', ['tag' => $business->profile->tag, 'business' => $business->id, 'active_action' => 'add-product' ]) }}">
            <span class="fa-stack fa-2x">
                <i class="text-blue-800 fas fa-circle fa-stack-2x"></i>
                <i class="text-white fa-stack-1x fas fa-plus"></i>
            </span>
        </a>
    </div>
    @endif

    <div class="w-full" wire:loading>
        <x-loader />
    </div>

    <div>
        @if($active_product)
        <div class="mb-4 ml-4 sm:ml-0">
            <x-jet-button wire:click="viewAll">
                <i class="fas fa-arrow-circle-left"></i> &nbsp; {{ __('All products') }}
            </x-jet-button>
        </div>

        <div>
            @livewire('build-and-manage.product.product-dashboard', ['product' => $active_product])
        </div>

        @else
        <div x-data x-init="() => { window.scrollTo(0, 0); }" class="@if($products->count() > 0) grid gap-2 sm:gap-2 grid-cols-2 sm:grid-cols-3 md:grid-cols-6 @endif px-2 sm:px-0">
            @forelse ($products as $product)
            <div wire:click="switchActiveProduct('{{ $product->id }}')" class="px-3 py-3 bg-gray-100 cursor-pointer">
                <div class="flex items-center justify-center">
                    <img src="/storage/{{ $product->displayImage() }}" width="150" height="150" />
                </div>

                <div class="pt-2 text-center">
                    <div class="truncate">
                        {{ $product->name }}
                    </div>

                    <div class="truncate">
                        {!! $product->price() !!}
                    </div>
                </div>

                @if ($product->is_published)
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
                        your product store is empty.
                    </span>
                </div>
            </div>
            @endforelse
        </div>

        <x-paginator :data="$products" />
    </div>
    @endif
    @if($active_product)
    <script>
        window.modifyUrl("/business/{{ $business->profile->full_tag() }}/{{ $business->id }}/products/{{ $active_product->id }}")

    </script>
    @endif
</div>