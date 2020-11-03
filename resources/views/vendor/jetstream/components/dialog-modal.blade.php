@props(['id' => null, 'maxWidth' => null, 'padding' => null])
<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="sm:px-6 py-4">
        <div class="px-3 text-lg">
            {{ $title }}
        </div>

        <div class="mt-4 {{ $padding ?? 'px-3' }}">
            {{ $content }}
        </div>
    </div>

    <div class="px-3 sm:px-6 py-4 bg-gray-100 text-right">
        {{ $footer }}
    </div>
</x-jet-modal>
