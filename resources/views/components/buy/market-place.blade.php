<div x-data="{ display_categories: false }" class="sticky bg-gray-100 bg-opacity-100 md:mb-2 top-12">
    <div class="flex">
        <a :class="{'bg-white text-blue-700': !display_categories}"
            class="flex-shrink-0 px-3 py-2 text-lg font-semibold text-center text-blue-700" href="{{ route('shop.index') }}">
            <i class="fas fa-store"></i> Market Place
        </a>
        {{--  <div :class="{'bg-white text-blue-700': display_categories}" @click=" display_categories = !display_categories "
            class="flex-shrink-0 p-3 text-lg font-semibold text-center cursor-pointer select-none">
            Shop By Categories
        </div>
    </div>
    <div x-show="display_categories" class="p-3 border-t border-gray-300">
        no categories to display.
    </div>
    --}}
</div>