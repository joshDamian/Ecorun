<x-app-layout>
    <div class="grid grid-cols-2 gap-2 sm:gap-3 sm:grid-cols-4 md:grid-cols-5">
        @foreach ($categories as $category)
        <a class="block" title="{{ $category->title }}" href="{{ route('category.show', ['slug' => $category->data_slug('title')]) }}">
            <div class="flex items-center justify-center bg-white shadow">
                <div>
                    @if($category->products->first())
                    <img src="/storage/{{ $category->products->first()->displayImage() }}" class="w-full h-full" />
                    @endif
                    <p title="{{ $category->title }}" class="px-2 py-2 text-center truncate">{{ $category->title }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</x-app-layout>
