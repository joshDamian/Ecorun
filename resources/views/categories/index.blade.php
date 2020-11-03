<x-app-layout>
    <x-landing-page>
        <div class="grid gap-2 sm:gap-3 grid-cols-2 sm:grid-cols-4 md:grid-cols-5">
            @foreach ($categories as $category)
            <a title="{{ $category->title }}" href="{{ route('category.show', ['slug' => $category->data_slug('title')]) }}">
                <div class="bg-white flex justify-center items-center shadow">
                    <div>
                        @if($category->products->first())
                        <img src="/storage/{{ $category->products->first()->displayImage() }}" />
                        @endif
                        <p title="{{ $category->title }}" class="py-2 truncate px-2 text-center">{{ $category->title }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </x-landing-page>
</x-app-layout>
