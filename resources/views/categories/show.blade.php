<x-app-layout>

    <div>
        @if($category->isParent())
        <div class="text-md mb-1 font-semibold"><i class="fas text-blue-700 fa-square"></i> {{ ucwords($category->title) }}</div>
        <div class="grid-cols-1 grid gap-3">
            @foreach($category->children as $category)
            <div>
                <x-category.category-products :category="$category->title" />
            </div>
            @endforeach
        </div>
        @else
        <div>
            <x-category.category-products :category="$category->title" :pagination="true" />
        </div>
        @endif
    </div>

</x-app-layout>
