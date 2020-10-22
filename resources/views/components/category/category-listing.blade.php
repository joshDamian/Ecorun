<div>
    <p class="mb-2 px-3 text-blue-700 font-medium text-md">
        <i class="fa fa-clipboard-list"></i> Our Categories
    </p>
    @foreach($categories as $category)
    <div class="@if(!$loop->last) mb-2 @endif px-3" x-data="{ '{{ $iterable_titles[$category->title] }}': false }">
        <span class="cursor-pointer text-md" @click=" {{ $iterable_titles[$category->title] }} = ! {{ $iterable_titles[$category->title] }} "><i :class="{{ $iterable_titles[$category->title] }} ? 'fa text-blue-700 fa-chevron-down' : 'fa text-pink-700 fa-chevron-right'"></i> &nbsp;{{ ucwords($category->title) }}</span> <a href="{{ route('category.show', ['category' => $category->title]) }}"><i class="fa text-sm text-green-600 fa-arrow-right"></i></a>
        <template x-if="{{ $iterable_titles[$category->title] }}">
            <div x-transition:enter="transition ease-out duration-300" class="mb-1 mt-1 px-6">
                @foreach($category->children as $category)
                <a href="{{ route('category.show', ['category' => $category->title]) }}">
                    <div class="@if(!$loop->last) mb-2 @endif  text-blue-700">
                        {{ ucwords($category->title) . ' ('. $category->products->count() . ')' }}
                    </div>
                </a>
                @endforeach
            </div>
        </template>
    </div>
    @endforeach
</div>
