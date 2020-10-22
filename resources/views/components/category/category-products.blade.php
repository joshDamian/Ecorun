<div>
    <a href="{{ route('category.show', ['category' => $category->title]) }}">
        <div class="mb-2 text-blue-700">
            {{ ucwords($category->title) }}
        </div>
    </a>
    @if($products->count() > 0)
    <x-product.user-product-list :products="$products" />
    @if($pagination)
    <x-paginator :data="$products" />
    @else
    @if($category->products->count() > 6)
    <div class="mt-2 text-right">
        <a href="{{ route('category.show', ['category' => $category->title]) }}">
            <x-jet-button class="bg-blue-700">
                {{ __('see more') }}
            </x-jet-button>
        </a>
    </div>
    @endif
    @endif
    @else
    <div class="bg-white py-3 px-3">
        <div class="flex justify-center py-2 px-2 items-center">
            <i style="font-size: 7rem;" class="fas text-blue-700 fa-shopping-bag"></i>
        </div>
        <div class="flex justify-center text-blue-700">
            there are not products for {{ $category->title }} category
        </div>
    </div>
    @endif
</div>
