<div>
    <a href="{{ route('category.index') }}">
        <p class="mb-2 px-3 text-blue-700 cursor-pointer font-semibold text-md">
            <i class="fa fa-clipboard-list"></i> Shop by categories
        </p>
    </a>
    @foreach($categories as $category)
    <div class="@if(!$loop->last) mb-2 @endif px-3" x-data="{ '{{ $iterable_titles[$category->title] }}': false }">
        <span class="cursor-pointer text-md" @click=" {{ $iterable_titles[$category->title] }} = ! {{ $iterable_titles[$category->title] }} "><i :class="{{ $iterable_titles[$category->title] }} ? 'fa text-blue-700 fa-chevron-down' : 'fa text-pink-600 fa-chevron-right'"></i> &nbsp;{{ ucwords($category->title) }}</span>
        <a href="{{ route('category.show', ['slug' => $category->data_slug('title')]) }}"> &nbsp;<i title="expand this group" class="fa text-sm text-green-600 fa-expand"></i></a>
        <template x-if="{{ $iterable_titles[$category->title] }}">
            <div x-transition:enter="transition ease-out duration-300" class="mb-1 mt-1 px-6">
                @foreach($category->children as $category)
                <a href="{{ route('category.show', ['slug' => $category->data_slug('title')]) }}">
                    <div class="@if(!$loop->last) mb-2 @endif  text-blue-700">
                        {{ ucwords($category->title) . ' ('. $category->products()->where('is_published', true)->get()->count() . ')' }}
                    </div>
                </a>
                @endforeach
            </div>
        </template>
    </div>
    @endforeach
</div>
