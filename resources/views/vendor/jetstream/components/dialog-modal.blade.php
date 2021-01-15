@props(['id' => null, 'maxWidth' => null, 'padding' => null])
<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="py-4 sm:px-6">
        <div class="px-3 text-lg">
            {{ $title }}
        </div>

        <div class="mt-4 {{ $padding ?? 'px-3' }}">
            {{ $content }}
        </div>
    </div>

    <div class="px-3 py-4 text-right bg-gray-100 sm:px-6">
        {{ $footer }}
    </div>
</x-jet-modal>
